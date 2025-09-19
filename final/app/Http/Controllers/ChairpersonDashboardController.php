<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssignedMail;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\DocumentRejectionHistory;
use App\Models\Task;
use App\Models\User;
use App\Models\Status;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Task_User;
use App\Models\TaskComment;
use Illuminate\Support\Facades\Log;

class ChairpersonDashboardController extends Controller
{
    // Cache status IDs to avoid repeated queries
    protected $statusIds = [];

    public function __construct()
    {
        $this->statusIds = [
            'completed' => Status::firstOrCreate(['name' => 'completed'])->id,
            'pending_approval' => Status::firstOrCreate(['name' => 'pending_approval'])->id,
            'pending' => Status::firstOrCreate(['name' => 'pending'])->id,
            'rejected' => Status::firstOrCreate(['name' => 'rejected'])->id,
            'in_progress' => Status::firstOrCreate(['name' => 'in_progress'])->id,
        ];
    }

    public function index()
    {
        $departmentId = Auth::user()->department_id;

        // Fetch tasks by status
        $pendingTasks = $this->getTasksByStatus($this->statusIds['pending'], $departmentId);
        $inProgressTasks = $this->getTasksByStatus($this->statusIds['in_progress'], $departmentId);
        $completedTasks = $this->getTasksByStatus($this->statusIds['completed'], $departmentId);

        // Summary statistics
        $totalTasks = Task::whereHas('users', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->count();

        $pendingCount = count($pendingTasks);
        $inProgressCount = count($inProgressTasks);
        $completedCount = count($completedTasks);

        return view('chairperson.dashboard', compact(
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'totalTasks',
            'pendingCount',
            'inProgressCount',
            'completedCount'
        ));

    }

    public function pendingApprovals()
    {
        $pendingApprovals = Task::whereHas('users', function ($query) {
            $query->where('status_id', $this->statusIds['pending_approval']);
        })
            ->with([
                'priority',
                'creator',
                'users' => function ($query) {
                    $query->withPivot('status_id');
                }
            ])
            ->orderBy('due_date', 'asc')
            ->paginate(10)
            ->through(function ($task) {
                $task->current_status = Status::find($task->users->first()->pivot->status_id ?? null);
                return $task;
            });

        return view('chairperson.pending-approvals', compact('pendingApprovals'));
    }

    public function reviewTask($id)
    {
        $task = Task::with([
            'priority',
            'creator',
            'assignees' => function ($query) {
                $query->withPivot('status_id');
            },
            'comments.user',
            'attachments'
        ])
            ->findOrFail($id);

        $task->current_status = Status::find($task->assignees->first()->pivot->status_id ?? null);



        return view('chairperson.task-review', compact('task'));
    }

    public function approveTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->users()->updateExistingPivot(Auth::id(), [
            'status_id' => $this->statusIds['completed']
        ]);

        return redirect()->route('chairperson.dashboard')->with('success', 'Task approved successfully!');
    }

    public function rejectTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->users()->updateExistingPivot(Auth::id(), [
            'status_id' => $this->statusIds['pending']
        ]);

        return redirect()->route('chairperson.dashboard')->with('success', 'Task rejected and sent back for revision!');
    }

    public function teamPerformance()
    {
        $departmentId = Auth::user()->department_id;

        $teamMembers = User::where('department_id', $departmentId)
            ->with([
                'tasks' => function ($query) {
                    $query->withPivot('status_id');
                }
            ])
            ->where('id', '!=', Auth::id())
            ->where('id', '!=', 1) // Exclude users with user_id 1
            ->get();
        // Display all team members (for debugging or inspection)
        // You can return as JSON or pass to the view as needed
        // Example: return response()->json($teamMembers);
        // Or simply pass to the view (already done below)
        // dd($teamMembers); // Uncomment for debugging

        return view('chairperson.team-performance', compact('teamMembers'));
    }

    public function upcomingTasks()
    {
        $upcomingDeadlines = Task::where('due_date', '>=', now())
            ->with([
                'priority',
                'assignees' => function ($query) {
                    $query->withPivot('status_id');
                }
            ])
            ->orderBy('due_date', 'asc')
            ->paginate(10)
            ->through(function ($task) {
                $task->current_status = Status::find($task->assignees->first()->pivot->status_id ?? null);
                return $task;
            });

        return view('chairperson.upcoming-tasks', compact('upcomingDeadlines'));
    }

    public function activityLog()
    {
        $recentActivity = Task::with([
            'creator',
            'users' => function ($query) {
                $query->withPivot('status_id');
            }
        ])
            ->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->through(function ($task) {
                $task->current_status = Status::find($task->users->first()->pivot->status_id ?? null);
                return $task;
            });

        return view('chairperson.activity-log', compact('recentActivity'));
    }
    function rejectDocument($id,$reason ){
        return response()->json(['message'=>'Document Rejected']);
    }
    public function approveAssignee(Task $task, User $user)
    {
        // Update the assignee's status to completed
        $task->users()->updateExistingPivot($user->id, [
            'status_id' => $this->statusIds['completed']
        ]);

        // Mark all submitted documents by this user for this task as approved,
        // and update reviewed_by and reviewed_at fields
        foreach ($task->submittedDocuments->where('user_id', $user->id) as $submittedDoc) {
            $submittedDoc->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        }

        return back()->with('success', "Approved task for {$user->name}");
    }
    /**
     * Format bytes to human readable string.
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        if ($bytes < 1024)
            return $bytes . ' B';
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
    }

    /**
     * Get color for status name.
     */
    protected function getStatusColor($statusName)
    {
        $colors = [
            'pending' => '#f1c40f',
            'in_progress' => '#3498db',
            'completed' => '#2ecc71',
            'rejected' => '#e74c3c',
            'pending_approval' => '#9b59b6',
        ];
        return $colors[$statusName] ?? '#95a5a6';
    }
    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);

        // Detach all associated users
        $task->users()->detach();

        // Delete all associated attachments
        foreach ($task->attachments as $attachment) {
            $attachment->delete();
        }
        // Delete all associated comments
        foreach ($task->comments as $comment) {
            $comment->delete();
        }
        // Delete the task
        $task->delete();

        return back()->with('success', 'Task deleted successfully!');
    }

    public function rejectAssignee(Task $task, User $user)
    {
        $task->users()->updateExistingPivot($user->id, [
            'status_id' => $this->statusIds['rejected']
        ]);

        return back()->with('success', "Rejected task for {$user->name}");
    }
    public function taskManagement()
    {
        $departmentId = Auth::user()->department_id;

        // Get all assignees in the department
        $assignees = User::where('department_id', $departmentId)
            ->where('id', '!=', Auth::id())
            ->withCount([
                'tasks' => function ($query) {
                    $query->where('status_id', $this->statusIds['pending_approval']);
                }
            ])
            ->orderBy('name')
            ->get();

        // All tasks for the department
        $tasks = Task::with([
            'priority',
            'creator',
            'users' => function ($query) {
            $query->withPivot('status_id');
            },
            'assignees' => function ($query) {
            $query->select('users.id', 'users.name');
            }
        ])
            ->where('created_by', Auth::id())
            ->whereHas('users', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
            })
            ->latest()
            ->get()
            ->each(function ($task) {
            $task->current_status = $task->users->first()->pivot->status_id
                ? Status::find($task->users->first()->pivot->status_id)
                : null;
            $task->assignee_names = $task->assignees->pluck('name')->toArray();
            });

        // Get tasks by status
        $pendingApprovals = User::with([
            'taskAssignments' => function ($query) {
                $query->where('status_id', $this->statusIds['pending_approval'])
                    ->with('task', 'status'); // assumes task and status relationships exist in TaskUser model
            }
        ])->whereHas('taskAssignments', function ($query) {
            $query->where('status_id', $this->statusIds['pending_approval']);
        })->where('department_id', $departmentId)->get();
        // dd($pendingApprovals);
        $inProgressTasks = User::with([
            'taskAssignments' => function ($query) {
                $query->whereIn('status_id', [$this->statusIds['in_progress'], $this->statusIds['pending']])
                    ->with('task', 'status'); // assumes task and status relationships exist in TaskUser model
            }
        ])->whereHas('taskAssignments', function ($query) {
            $query->whereIn('status_id', [$this->statusIds['in_progress'], $this->statusIds['pending']]);
        })->where('department_id', $departmentId)->get();

        $completedTasks = User::with([
            'taskAssignments' => function ($query) {
                $query->where('status_id', $this->statusIds['completed'])
                    ->with('task', 'status'); // assumes task and status relationships exist in TaskUser model
            }
        ])->whereHas('taskAssignments', function ($query) {
            $query->where('status_id', $this->statusIds['completed']);
        })->where('department_id', $departmentId)->get();

        $myTasks = Task::whereHas('assignees', function ($query) {
            $query->where('user_id', Auth::id()); // Only tasks assigned to current user
        })
            ->with(['priority', 'assignees'])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('chairperson.taskmanagement', compact(
            'tasks',
            'pendingApprovals',
            'inProgressTasks',
            'completedTasks',
            'assignees',
            'myTasks'
        ));
    }



    /**
     * Format bytes to human readable string.
     */


    /**
     * Get color for status name.
     */

    protected function getTasksByStatus($statusId, $departmentId)
    {
        return Task::with([
            'priority',
            'creator',
            'users' => function ($query) {
                $query->withPivot('status_id');
            }
        ])
            ->whereHas('users', function ($query) use ($statusId, $departmentId) {
                $query->where('status_id', $statusId)
                    ->where('department_id', $departmentId);
            })
            ->latest()
            ->get()
            ->each(function ($task) {
                $task->current_status = $task->users->first()->pivot->status_id
                    ? Status::find($task->users->first()->pivot->status_id)
                    : null;
            });
    }
    public function create()
    {
        // Get the authenticated user's department ID
        $userDepartmentId = Auth::user()->department_id;

        // Get users from the same department, excluding the auth user
        $users = User::where('department_id', $userDepartmentId)
            ->where('id', '!=', Auth::id())
            ->get();

        $priorities = Priority::all();

        // Get departments with their users (filtered to same department)
        $departments = Department::with([
            'users' => function ($query) use ($userDepartmentId) {
                $query->where('department_id', $userDepartmentId)
                    ->where('id', '!=', Auth::id());
            }
        ])
            ->where('id', $userDepartmentId)
            ->get();

        // Get recent tasks created by auth user (no department filter needed here)
        $recentTasks = Task::where('created_by', Auth::id())
            ->with(['assignees', 'priority'])
            ->latest()
            ->take(5)
            ->get();

        return view('chairperson.assigntask', compact('users', 'priorities', 'departments', 'recentTasks'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'priority_id' => 'required|exists:priorities,id',
            'assignees' => 'required|array',
            'assignees.*' => 'required|exists:users,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'],
            'priority_id' => $validated['priority_id'],
            'created_by' => Auth::id(),
        ]);

        $defaultStatus = Status::where('name', 'pending')->first();

        foreach ($validated['assignees'] as $userId) {
            $task->assignees()->attach($userId, ['status_id' => $defaultStatus->id]);
        }

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $mimeType = $file->getMimeType();
                $folder = 'others';

                if (str_starts_with($mimeType, 'image')) {
                    $folder = 'images';
                } elseif (str_starts_with($mimeType, 'application/pdf')) {
                    $folder = 'documents';
                } elseif (str_starts_with($mimeType, 'video')) {
                    $folder = 'videos';
                } elseif (str_starts_with($mimeType, 'audio')) {
                    $folder = 'audios';
                } elseif (
                    str_starts_with($mimeType, 'application/vnd.ms-excel') ||
                    str_contains($mimeType, 'spreadsheetml')
                ) {
                    $folder = 'spreadsheets';
                }

                $path = $file->store("{$folder}", 'public');
                Attachment::create([
                    'task_id' => $task->id,
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $mimeType,
                    'size' => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }

        foreach ($validated['assignees'] as $assigneeId) {
            $assignee = User::find($assigneeId);
            Mail::to($assignee->email)->send(new TaskAssignedMail($task, $assignee));
        }

        return back()->with('success', 'Task has been assigned successfully!');
    }
    public function settings()
    {
        return view('chairperson.settings');
    }


    public function taskDetails($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required. Please login again.',
                'redirect' => url('/login')
            ], 401);
        }

        $user = Auth::user();

        try {
            $task = Task::with([
                'priority',
                'creator',
                'attachments',
                'comments.user',
                'users.department',
                'requiredDocuments',
                'submittedDocuments.user',
                'submittedDocuments.requiredDocument',
                'submittedDocuments.reviewer',
            ])->findOrFail($id);

            // Chairpersons can view all tasks, regular users only their assigned tasks
            $isChairperson = $user->role_id === 2;
            $isAssigned = $task->users->contains('id', $user->id);

            if (!$isChairperson && !$isAssigned) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. You are not assigned to this task.'
                ], 403);
            }

            // Get all assignees with their status and submission details
            $assigneesWithDetails = [];
            foreach ($task->users as $assignee) {
                $userSubmittedDocs = $task->submittedDocuments->where('user_id', $assignee->id);

                $assigneesWithDetails[] = [
                    'id' => $assignee->id,
                    'name' => $assignee->name,
                    'email' => $assignee->email,
                    'department' => $assignee->department->name ?? 'No Department',
                    'avatar_url' => $assignee->avatar_url ?? asset('storage/profile/avatars/profile.png'),
                    'status' => $assignee->pivot->status->name ?? 'pending',
                    'status_id' => $assignee->pivot->status_id,
                    'submitted_documents_count' => $userSubmittedDocs->count(),
                    'approved_documents_count' => $userSubmittedDocs->where('status', 'approved')->count(),
                    'submitted_documents' => $userSubmittedDocs->map(function ($doc) {
                        return [
                            'id' => $doc->id,
                            'required_document_name' => $doc->requiredDocument->name,
                            'filename' => $doc->filename,
                            'status' => $doc->status,
                            'submitted_at' => $doc->created_at->format('M d, Y h:i A'),
                            'reviewed_at' => $doc->reviewed_at?->format('M d, Y h:i A'),
                            'rejection_reason' => $doc->rejection_reason,
                        ];
                    })
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'require_documents' => $task->require_documents,
                    'priority' => [
                        'id' => $task->priority->id,
                        'name' => $task->priority->name,
                        'level' => $task->priority->level
                    ],
                    'due_date' => $task->due_date->format('Y-m-d'),
                    'due_date_formatted' => $task->due_date->format('M d, Y'),
                    'due_date_passed' => $task->due_date->isPast(),
                    'days_remaining' => max(0, now()->diffInDays($task->due_date, false)),
                    'creator' => [
                        'id' => $task->creator->id,
                        'name' => $task->creator->name,
                        'email' => $task->creator->email,
                        'avatar_url' => $task->creator->avatar_url ?? asset('storage/profile/avatars/profile.png'),
                        'department' => $task->creator->department->name ?? 'No Department'
                    ],
                    'assignees' => $assigneesWithDetails,
                    'created_at' => $task->created_at->format('Y-m-d H:i:s'),
                    'created_at_formatted' => $task->created_at->format('M d, Y h:i A'),
                    'time_elapsed' => $task->created_at->diffForHumans(),
                    'attachments' => $task->attachments->map(function ($attachment) {
                        return [
                            'id' => $attachment->id,
                            'original_name' => $attachment->filename,
                            'path' => $attachment->path,
                            'mime_type' => $attachment->type,
                            'size' => $attachment->size,
                            'size_formatted' => $this->formatBytes($attachment->size),
                            'url' => Storage::url($attachment->path),
                            'uploaded_at' => $attachment->created_at->format('M d, Y h:i A'),
                            'uploaded_by' => $attachment->uploader->name ?? 'Unknown'
                        ];
                    }),
                    'comments' => $task->comments->map(function ($comment) {
                        return [
                            'id' => $comment->id,
                            'content' => $comment->comment,
                            'created_at' => $comment->created_at->format('M d, Y h:i A'),
                            'created_at_timestamp' => $comment->created_at->timestamp,
                            'is_edited' => $comment->created_at != $comment->updated_at,
                            'user' => [
                                'id' => $comment->user->id,
                                'name' => $comment->user->name,
                                'avatar_url' => $comment->user->avatar_url ?? asset('storage/profile/avatars/profile.png'),
                                'role' => $comment->user->role->name ?? 'User'
                            ]
                        ];
                    })->sortByDesc('created_at_timestamp')->values(),
                    'required_documents' => $task->requiredDocuments->map(function ($document) use ($task, $user) {
                        // Check if current user has submitted this document
                        $userSubmission = $task->submittedDocuments
                            ->where('user_id', $user->id)
                            ->where('required_document_id', $document->id)
                            ->first();

                        return [
                            'id' => $document->id,
                            'name' => $document->name,
                            'type' => $document->type,
                            'description' => $document->description,
                            'is_required' => $document->is_required ?? true,
                            'created_at' => $document->created_at->format('M d, Y'),
                            'is_submitted' => $userSubmission !== null,
                            'submission_status' => $userSubmission->status ?? null,
                            'submission_rejection_reason' => $userSubmission->rejection_reason ?? null,
                        ];
                    }),
                    'overall_status' => $this->getOverallTaskStatus($task),
                    'completion_stats' => $this->getCompletionStats($task),
                    'is_chairperson' => $isChairperson,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Task details error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load task details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // Add these helper methods to your controller
    protected function getOverallTaskStatus($task)
    {
        $statuses = $task->users->pluck('pivot.status_id')->unique();

        // Get status IDs from database
        $statusIds = [
            'pending' => Status::where('name', 'pending')->first()->id,
            'in_progress' => Status::where('name', 'in_progress')->first()->id,
            'completed' => Status::where('name', 'completed')->first()->id,
            'rejected' => Status::where('name', 'rejected')->first()->id,
            'pending_approval' => Status::where('name', 'pending_approval')->first()->id,
        ];

        if ($statuses->contains($statusIds['rejected'])) {
            return 'rejected';
        }
        if ($statuses->contains($statusIds['pending_approval'])) {
            return 'pending_approval';
        }
        if ($statuses->contains($statusIds['in_progress'])) {
            return 'in_progress';
        }
        if ($statuses->contains($statusIds['pending'])) {
            return 'pending';
        }
        if ($statuses->count() === 1 && $statuses->first() == $statusIds['completed']) {
            return 'completed';
        }

        return 'mixed';
    }

    protected function getCompletionStats($task)
    {
        $totalAssignees = $task->users->count();
        $completedStatusId = Status::where('name', 'completed')->first()->id;
        $completedAssignees = $task->users->where('pivot.status_id', $completedStatusId)->count();

        return [
            'total_assignees' => $totalAssignees,
            'completed_assignees' => $completedAssignees,
            'completion_percentage' => $totalAssignees > 0 ? round(($completedAssignees / $totalAssignees) * 100) : 0,
        ];
    }


    // Add these helper methods to your controller

   
    public function bulkApprove(Request $request)
    {
        try {
            $approvals = json_decode($request->input('approvals'), true);

            foreach ($approvals as $approval) {
                $task = Task::findOrFail($approval['taskId']);
                $task->users()->updateExistingPivot($approval['assigneeId'], [
                    'status_id' => $this->statusIds['completed']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tasks approved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkReject(Request $request)
    {
        try {
            $rejections = json_decode($request->input('rejections'), true);
            $reason = $request->input('reason');

            foreach ($rejections as $rejection) {
                $task = Task::findOrFail($rejection['taskId']);
                $task->users()->updateExistingPivot($rejection['assigneeId'], [
                    'status_id' => $this->statusIds['rejected'],
                    'rejection_reason' => $reason
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tasks rejected successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function rejectWithReason(Request $request, $taskId, $userId)
    {
        try {
            $task = Task::findOrFail($taskId);
            $task->users()->updateExistingPivot($userId, [
                'status_id' => $this->statusIds['rejected'],
                'rejection_reason' => $request->input('reason')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task rejected successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject task',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function addComment(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'required|string|max:1000'
        ]);

        try {
            $comment = TaskComment::create([
                'task_id' => $request->task_id,
                'user_id' => Auth::id(),
                'comment' => $request->comment
            ]);

            // Load the user relationship for the response
            $comment->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'data' => $comment
            ]);

        } catch (\Exception $e) {
            Log::error('Comment creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to add comment. Please try again.'
            ], 500);
        }
    }

}