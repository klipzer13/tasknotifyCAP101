<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Priority;
use App\Models\Task;
use App\Models\Status;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\TaskComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedMail;
use App\Models\RequiredDocument;
use App\Models\SubmittedDocument;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $statuses = Status::all();
        $priorities = Priority::all();
        $users = User::where('id', '!=', Auth::id())->get();
        $attachments = Attachment::all();

        $query = Task::with(['priority', 'users', 'creator'])
            ->withCount('users')
            ->latest();

        if ($request->has('status_id') && $request->status_id) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('status_id', $request->status_id);
            });
        }

        if ($request->has('priority_id') && $request->priority_id) {
            $query->where('priority_id', $request->priority_id);
        }

        if ($request->has('assignee') && $request->assignee) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('user_id', $request->assignee);
            });
        }

        if ($request->has('due_date') && $request->due_date) {
            switch ($request->due_date) {
                case 'today':
                    $query->whereDate('due_date', today());
                    break;
                case 'week':
                    $query->whereBetween('due_date', [now(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereBetween('due_date', [now(), now()->endOfMonth()]);
                    break;
                case 'overdue':
                    $query->whereDate('due_date', '<', today());
                    break;
            }
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $tasks = $query->paginate(10);
        return view('admin.alltask', compact('tasks', 'statuses', 'priorities', 'users'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $priorities = Priority::all();
        $departments = Department::where('id', '!=', 1)->with('users')->get();
        $recentTasks = Task::where('created_by', Auth::id())
            ->with(['assignees', 'priority'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.assigntask', compact('users', 'priorities', 'departments', 'recentTasks'));
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'required|date',
                'assignees' => 'required|array',
                'assignees.*' => 'exists:users,id',
                'attachments' => 'nullable|array',
                'attachments.*' => 'file|max:10240',
                'require_documents' => 'nullable|boolean',
                'documents' => 'nullable|array',
                'documents.*.name' => 'required_if:require_documents,1|string|max:255',
                'documents.*.type' => 'required_if:require_documents,1|string|max:50',
                'documents.*.description' => 'nullable|string',
            ]);

            // Calculate priority based on due date
            $dueDate = \Carbon\Carbon::parse($validated['due_date']);
            $daysDiff = now()->diffInDays($dueDate, false);

            if ($daysDiff < 3) {
                $validated['priority_id'] = 1; // High priority
            } elseif ($daysDiff >= 3 && $daysDiff <= 5) {
                $validated['priority_id'] = 2; // Medium priority
            } else {
                $validated['priority_id'] = 3; // Low priority
            }

            // Manual insert instead of Eloquent create
            $taskData = [
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'due_date' => $validated['due_date'],
                'priority_id' => $validated['priority_id'],
                'created_by' => Auth::id(),
                'require_documents' => $request->has('require_documents') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $taskId = DB::table('tasks')->insertGetId($taskData);

            // Get the task instance for relationships
            $task = Task::find($taskId);

            $defaultStatus = Status::where('name', 'pending')->first();

            // Assign task to users
            foreach ($validated['assignees'] as $userId) {
                $task->assignees()->attach($userId, ['status_id' => $defaultStatus->id]);
            }

            // Handle document requirements if needed
            if ($request->has('require_documents') && $request->require_documents == 1 && $request->has('documents')) {
                foreach ($request->documents as $documentData) {
                    DB::table('required_documents')->insert([
                        'task_id' => $taskId,
                        'name' => $documentData['name'],
                        'type' => $documentData['type'],
                        'description' => $documentData['description'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Handle file attachments
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

            // Send email notifications to assignees
            foreach ($validated['assignees'] as $assigneeId) {
                $assignee = User::find($assigneeId);
                Mail::to($assignee->email)->queue(new TaskAssignedMail($task, $assignee));
            }
            // Log the task creation
            Log::info('Task created', [
                'task_title' => $task->title,
                'created_by' => 'name ' . Auth::user()->name . ' ID ' . Auth::id(),
                'assignees' => User::whereIn('id', $validated['assignees'])->pluck('name')->toArray(),
                'require_documents' => $task->require_documents,
                'document_count' => $request->has('documents') ? count($request->documents) : 0,
            ]);

            // Your existing validation and task creation code...

            // Instead of return back()->with('success', ...)
            return response()->json([
                'success' => true,
                'message' => 'Task has been assigned successfully!',
                'task_id' => $taskId
            ]);

        } catch (\Exception $e) {
            Log::error('Task assignment failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign task. Please try again.'
            ], 500);
        }

    }
    public function dash()
    {
        $totalTasks = Task::count();
        $totalMembers = User::count();

        $inProgressTasks = Task::whereHas('users', function ($query) {
            $query->whereIn('status_id', [1, 2]);
        })->count();

        $completedTasks = Task::whereHas('users', function ($query) {
            $query->where('status_id', 3);
        })->count();

        $recentTasks = Task::with(['priority', 'users'])
            ->latest()
            ->take(4)
            ->get();

        $teamMembers = User::withCount('tasks')
            ->orderBy('tasks_count', 'desc')
            ->take(10)
            ->get();

        $statuses = Status::all();

        return view('admin.dashboard', compact(
            'totalTasks',
            'totalMembers',
            'inProgressTasks',
            'completedTasks',
            'recentTasks',
            'teamMembers',
            'statuses'
        ));
    }
    public function department()
    {
        // Get all departments except the one with id = 1, with their users count and users
        $departments = Department::where('id', '!=', 1)
            ->withCount(['users as users_count'])
            ->with([
                'users' => function ($query) {
                    $query->withCount(['tasks as tasks_count'])
                        ->with('role')
                        ->orderBy('name');
                }
            ])
            ->orderBy('name')
            ->get();

        // Manually assign the head (user with role_id = 2) for each department
        foreach ($departments as $department) {
            $head = collect($department->users)->first(function ($user) {
                return $user->role_id == 2;
            });
            $department->head = $head;
        }

        // Get all users for department assignment
        $allUsers = User::where('id', '!=', 1)->with('role')->orderBy('name')->get();

        // Dashboard stats
        $dashboardStats = [
            'totalTasks' => Task::count(),
            'totalMembers' => User::count(),
            'inProgressTasks' => Task::whereHas('users', function ($query) {
                $query->whereIn('status_id', [1, 2]);
            })->count(),
            'completedTasks' => Task::whereHas('users', function ($query) {
                $query->where('status_id', 3);
            })->count(),
        ];

        return view('admin.departments', compact(
            'departments',
            'dashboardStats',
            'allUsers'
        ));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
            'head_id' => 'required|exists:users,id',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            // Create the department
            $department = Department::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            // Update the head's role and department
            $head = User::find($request->head_id);
            $head->update([
                'role_id' => 2, // Department Head role
                'department_id' => $department->id
            ]);

            // Update selected members' department
            if ($request->has('members')) {
                User::whereIn('id', $request->members)
                    ->where('id', '!=', $request->head_id) // Don't update the head again
                    ->update(['department_id' => $department->id]);
            }

            DB::commit();

            return back()->with('success', 'Department created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Department creation failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to create department. Please try again.');
        }
    }

    public function updateDepartment(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'head_id' => 'required|exists:users,id',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            // Update department details
            $department->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            // Get current head before potential changes
            $currentHead = collect($department->users)->first(function ($user) {
                return $user->role_id == 2;
            });

            // If head changed, update previous head's role and new head
            if ($currentHead && $currentHead->id != $request->head_id) {
                // Reset previous head's role if they're in this department
                if ($currentHead->department_id == $department->id) {
                    $currentHead->update(['role_id' => 3]); // Regular user role
                }
            }

            // Update new head
            $newHead = User::find($request->head_id);
            $newHead->update([
                'role_id' => 2, // Department Head role
                'department_id' => $department->id
            ]);

            // Update members
            if ($request->has('members')) {
                // Ensure head is always included in members
                $members = array_unique(array_merge($request->members, [$request->head_id]));

                // Remove users no longer in department
                User::where('department_id', $department->id)
                    ->where('id', '!=', $request->head_id) // Don't remove the head
                    ->whereNotIn('id', $members)
                    ->update(['department_id' => 1]);

                // Add new members (excluding the head who was already updated)
                $membersToAdd = array_diff($members, [$request->head_id]);
                if (!empty($membersToAdd)) {
                    User::whereIn('id', $membersToAdd)
                        ->update(['department_id' => $department->id]);
                }
            } else {
                // If no members selected, remove all non-head users
                User::where('department_id', $department->id)
                    ->where('id', '!=', $request->head_id)
                    ->update(['department_id' => null]);
            }

            DB::commit();

            return back()->with('success', 'Department updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Department update failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to update department. Please try again.');
        }
    }
    public function editdata(Department $department)
    {
        // Load department with users and their roles
        $department->load([
            'users' => function ($query) {
                $query->with('role');
            }
        ]);

        // Find the head (user with role_id = 2)
        $department->head = collect($department->users)->first(function ($user) {
            return $user->role_id == 2;
        });


        return response()->json($department);
    }


    public function destroyDepartment(Department $department)
    {
        try {
            DB::beginTransaction();

            // Reset users' department and role (except keep head role if they're head of another department)
            $users = User::where('department_id', $department->id)->get();

            foreach ($users as $user) {
                // Check if user is head of this department
                if ($user->role_id == 2 && $user->department_id == $department->id) {
                    // Reset to regular user role
                    $user->update([
                        'role_id' => 3,
                        'department_id' => 1
                    ]);
                } else {
                    // Just remove from department
                    $user->update(['department_id' => 1]);
                }
            }

            // Delete the department
            $department->delete();

            DB::commit();
            return back()->with('success', 'Department deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Department deletion failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete department. Please try again.');
        }
    }
    public function getMembers(Department $department)
    {
        dd($department);
        $members = $department->users()
            ->with([
                'role',
                'tasks' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->withCount('tasks')
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'avatar_url' => $member->avatar_url,
                    'role' => $member->role->name ?? null,
                    'tasks_count' => $member->tasks_count,
                    'status' => $member->tasks->first()->status->name ?? null,
                    'current_task' => $member->tasks->first()->title ?? null
                ];
            });
        dd($members);

        return response()->json([
            'members' => $members
        ]);
    }
    function adddepartment(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            $department = Department::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return back()->with('success', 'Department added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add department: ' . $e->getMessage());
        }
    }

    public function documents()
    {
        $documents = Attachment::where('type', 'application/pdf')->get();
        return view('admin.documents', compact('documents'));
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
    public function submitTask(Request $request)
    {
        try {
            $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'required_documents' => 'required|array|min:1',
                'required_documents.*' => 'required|file|max:10240'
            ]);

            $task = Task::findOrFail($request->task_id);
            $user = Auth::user();

            // Check if user is assigned to this task
            $taskAssignment = DB::table('task_user')
                ->where('task_id', $task->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$taskAssignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not assigned to this task.'
                ], 403);
            }

            // Process each uploaded document
            foreach ($request->file('required_documents') as $docId => $file) {
                if (!$file->isValid()) {
                    continue; // Skip invalid files
                }

                // Check if this is a required document for the task
                $requiredDoc = RequiredDocument::where('id', $docId)
                    ->where('task_id', $task->id)
                    ->first();

                if (!$requiredDoc) {
                    Log::warning("Invalid document ID submitted: {$docId} for task: {$task->id}");
                    continue; // Skip if not a valid required document
                }

                // Check if document was already submitted
                $existingSubmission = SubmittedDocument::where('task_id', $task->id)
                    ->where('required_document_id', $docId)
                    ->where('user_id', $user->id)
                    ->first();

                // Determine folder based on file type
                $mimeType = $file->getMimeType();
                $folder = 'others';

                if (str_starts_with($mimeType, 'image/')) {
                    $folder = 'images';
                } elseif ($mimeType === 'application/pdf') {
                    $folder = 'documents';
                }

                // Store the file
                $path = $file->store("task_documents/{$folder}", 'public');

                if ($existingSubmission) {
                    // Update existing submission
                    $existingSubmission->update([
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $mimeType,
                        'size' => $file->getSize(),
                        'status' => 'pending',
                        'rejection_reason' => null // Reset rejection reason on reupload
                    ]);
                } else {
                    // Create new submitted document record
                    SubmittedDocument::create([
                        'task_id' => $task->id,
                        'required_document_id' => $docId,
                        'user_id' => $user->id,
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $mimeType,
                        'size' => $file->getSize(),
                        'status' => 'pending'
                    ]);
                }
            }

            // Check if any documents were actually submitted
            $submittedCount = SubmittedDocument::where('task_id', $task->id)
                ->where('user_id', $user->id)
                ->count();

            if ($submittedCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid documents were submitted.'
                ], 400);
            }

            // Update task status to pending_approval
            $pendingApprovalStatus = Status::where('name', 'pending_approval')->first();

            if ($pendingApprovalStatus) {
                DB::table('task_user')
                    ->where('task_id', $task->id)
                    ->where('user_id', $user->id)
                    ->update(['status_id' => $pendingApprovalStatus->id]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Task submitted successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Task submission failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit task. Please try again.'
            ], 500);
        }
    }


}