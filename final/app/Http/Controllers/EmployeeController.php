<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Status;
use App\Models\Attachment;
use App\Models\DocumentRejectionHistory;
use App\Models\TaskComment;
use App\Models\RejectionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function myTasks(Request $request)
    {
        $statuses = Status::all();

        $tasks = Task::with(['priority', 'creator', 'attachments', 'requiredDocuments', 'submittedDocuments'])
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('employee.mytask2', compact('tasks', 'statuses'));
    }

    public function taskDetails($id)
    {
        try {
            $task = Task::with([
                'priority',
                'creator.department', // Include creator's department
                'attachments.uploader', // Include uploader for attachments
                'comments.user.role', // Include user's role for comments
                'users.department', // Include users and their departments
                'requiredDocuments',
                'submittedDocuments.user', // Include user relationship for submitted documents
                'submittedDocuments.requiredDocument', // Include required document relationship
                'submittedDocuments.reviewer.department', // Include reviewer relationship with department
            ])
                ->whereHas('users', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($id);

            // Get current user's status for this task
            $userStatus = $task->users()->where('user_id', Auth::id())->first()->pivot->status_id;
            $status = Status::find($userStatus);

            // Get the current user's submitted documents for this task
            $userSubmittedDocuments = $task->submittedDocuments()
                ->where('user_id', Auth::id())
                ->get();

            // Get all statuses for reference
            $allStatuses = Status::all()->keyBy('id');

            // Calculate completion percentage
            $totalDocuments = $task->requiredDocuments->count();
            $approvedDocuments = $userSubmittedDocuments->where('status', 'approved')->count();
            $completionPercentage = $totalDocuments > 0 ? round(($approvedDocuments / $totalDocuments) * 100) : 0;

            // Get rejection history for submitted documents
            $rejectionHistories = [];
            foreach ($userSubmittedDocuments as $submittedDoc) {
                $histories = DB::table('rejection_history') // Use the correct table name
                    ->where('submitted_document_id', $submittedDoc->id)
                    ->join('users', 'rejection_history.rejected_by', '=', 'users.id')
                    ->orderBy('rejected_at', 'desc')
                    ->get()
                    ->map(function ($history) {
                        return [
                            'id' => $history->id,
                            'reason' => $history->reason,
                            'rejected_by' => $history->name ?? 'Unknown',
                            'rejected_by_id' => $history->rejected_by,
                            'rejected_at' => Carbon::parse($history->rejected_at)->format('M d, Y h:i A'),
                            'revision_number' => $history->revision_number
                        ];
                    })->toArray();

                $rejectionHistories[$submittedDoc->id] = $histories;
            }

            // Get all users assigned to this task with their status
            $assignedUsers = $task->users->map(function ($user) use ($task) {
                $userStatus = $task->users()->where('user_id', $user->id)->first()->pivot->status_id;
                $status = Status::find($userStatus);

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar_url' => $user->avatar_url ?? asset('storage/profile/avatars/profile.png'),
                    'department' => $user->department->name ?? 'No Department',
                    'status' => [
                        'id' => $status->id,
                        'name' => $status->name,
                        'label' => ucfirst(str_replace('_', ' ', $status->name)),
                    ],
                    'assigned_at' => $task->users()->where('user_id', $user->id)->first()->pivot->created_at->format('M d, Y')
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $status->name,
                    'status_id' => $status->id,
                    'require_documents' => $task->require_documents,
                    'priority' => [
                        'id' => $task->priority->id,
                        'name' => $task->priority->name,
                        'level' => $task->priority->level ?? null // if you have a priority level field
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
                            'uploaded_by' => $attachment->uploader->name ?? 'Unknown',
                            'uploaded_by_id' => $attachment->uploaded_by
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
                    'required_documents' => $task->requiredDocuments->map(function ($document) use ($userSubmittedDocuments, $rejectionHistories) {
                        $submittedDoc = $userSubmittedDocuments->firstWhere('required_document_id', $document->id);

                        return [
                            'id' => $document->id,
                            'name' => $document->name,
                            'type' => $document->type,
                            'description' => $document->description,
                            'is_required' => $document->is_required ?? true,
                            'created_at' => $document->created_at->format('M d, Y'),
                            'is_submitted' => !is_null($submittedDoc),
                            'submitted_document' => $submittedDoc ? [
                                'id' => $submittedDoc->id,
                                'filename' => $submittedDoc->filename,
                                'path' => $submittedDoc->path,
                                'mime_type' => $submittedDoc->mime_type,
                                'size' => $submittedDoc->size,
                                'size_formatted' => $this->formatBytes($submittedDoc->size),
                                'url' => Storage::url($submittedDoc->path),
                                'status' => $submittedDoc->status,
                                'status_label' => ucfirst($submittedDoc->status),
                                'rejection_reason' => $submittedDoc->rejection_reason,
                                'reviewed_by' => $submittedDoc->reviewer ? $submittedDoc->reviewer->name : null,
                                'reviewed_by_id' => $submittedDoc->reviewed_by,
                                'reviewed_at' => $submittedDoc->reviewed_at ? $submittedDoc->reviewed_at->format('M d, Y h:i A') : null,
                                'rejection_count' => $submittedDoc->rejection_count,
                                'rejection_histories' => $rejectionHistories[$submittedDoc->id] ?? [],
                                'created_at' => $submittedDoc->created_at->format('M d, Y h:i A'),
                                'updated_at' => $submittedDoc->updated_at->format('M d, Y h:i A'),
                                'can_reupload' => $submittedDoc->status === 'rejected'
                            ] : null
                        ];
                    }),
                    'submitted_documents' => $userSubmittedDocuments->map(function ($submittedDoc) use ($rejectionHistories) {
                        return [
                            'id' => $submittedDoc->id,
                            'required_document_id' => $submittedDoc->required_document_id,
                            'required_document_name' => $submittedDoc->requiredDocument->name,
                            'filename' => $submittedDoc->filename,
                            'path' => $submittedDoc->path,
                            'mime_type' => $submittedDoc->mime_type,
                            'size' => $submittedDoc->size,
                            'size_formatted' => $this->formatBytes($submittedDoc->size),
                            'url' => Storage::url($submittedDoc->path),
                            'status' => $submittedDoc->status,
                            'status_label' => ucfirst($submittedDoc->status),
                            'rejection_reason' => $submittedDoc->rejection_reason,
                            'reviewed_by' => $submittedDoc->reviewer ? $submittedDoc->reviewer->name : null,
                            'reviewed_by_id' => $submittedDoc->reviewed_by,
                            'reviewed_at' => $submittedDoc->reviewed_at ? $submittedDoc->reviewed_at->format('M d, Y h:i A') : null,
                            'rejection_count' => $submittedDoc->rejection_count,
                            'rejection_histories' => $rejectionHistories[$submittedDoc->id] ?? [],
                            'created_at' => $submittedDoc->created_at->format('M d, Y h:i A'),
                            'updated_at' => $submittedDoc->updated_at->format('M d, Y h:i A'),
                            'can_reupload' => $submittedDoc->status === 'rejected'
                        ];
                    }),
                    'assigned_users' => $assignedUsers,
                    'completion_stats' => [
                        'total_documents' => $totalDocuments,
                        'submitted_documents' => $userSubmittedDocuments->count(),
                        'approved_documents' => $approvedDocuments,
                        'rejected_documents' => $userSubmittedDocuments->where('status', 'rejected')->count(),
                        'pending_documents' => $userSubmittedDocuments->where('status', 'pending')->count(),
                        'completion_percentage' => $completionPercentage,
                        'is_complete' => $completionPercentage === 100,
                    ],
                    'permissions' => [
                        'can_submit' => in_array($status->name, ['pending', 'in_progress', 'rejected']),
                        'can_comment' => true,
                        'can_upload_documents' => in_array($status->name, ['pending', 'in_progress', 'rejected']),
                        'can_reupload' => $userSubmittedDocuments->where('status', 'rejected')->count() > 0,
                    ],
                    'all_statuses' => $allStatuses->map(function ($status) {
                        return [
                            'id' => $status->id,
                            'name' => $status->name,
                            'label' => ucfirst(str_replace('_', ' ', $status->name)),
                            'color' => $this->getStatusColor($status->name) // Make sure this method exists
                        ];
                    })->values()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load task details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Helper function to format bytes (make sure this exists in your controller)
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    // Helper function for status colors (make sure this exists)
    private function getStatusColor($status)
    {
        $colors = [
            'pending' => '#f59e0b',
            'in_progress' => '#3b82f6',
            'completed' => '#10b981',
            'rejected' => '#ef4444',
            'approved' => '#10b981'
        ];

        return $colors[$status] ?? '#6b7280';
    }
    /**
     * Format bytes to human-readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */


    public function submitTask(Request $request)
    {


        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:2048',
        ]);
        // dd($request->all());
        $task = Task::findOrFail($request->task_id);
        $user = Auth::user();
        $status = Status::where('name', 'pending_approval')->first();
        $task->users()->updateExistingPivot($user->id, [
            'status_id' => $status->id,
            'updated_at' => now()
        ]);
        if (!empty($request->comment)) {
            TaskComment::create([
                'task_id' => $task->id,
                'user_id' => $user->id,
                'comment' => $request->comment
            ]);
        }
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task_attachments');
                Attachment::create([
                    'task_id' => $task->id,
                    'uploaded_by' => $user->id,
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize()
                ]);
            }
        }
        return back()->with('success', 'Task submitted successfully');
    }

    public function markComplete($id)
    {
        $task = Task::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->findOrFail($id);

        $completedStatus = Status::where('name', 'completed')->first();

        $task->users()->updateExistingPivot(Auth::id(), [
            'status_id' => $completedStatus->id,
            'completed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task marked as complete'
        ]);
    }
    public function show($id)
    {
        $task = Task::with([
            'priority',
            'creator',
            'attachments',
            'comments.user',
            'users'
        ])
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        $userStatus = $task->users()->where('user_id', Auth::id())->first()->pivot->status_id;
        $status = Status::findOrFail($userStatus);

        return view('chairperson.task-details', [
            'task' => $task,
            'status' => $status
        ]);
    }
}