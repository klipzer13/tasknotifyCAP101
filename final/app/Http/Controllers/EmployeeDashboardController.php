<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Attachment;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        // Get task statistics for the current user
        $activeTasks = Task::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id())
                ->whereNotIn('status_id', [4]); // Not completed (3 = completed)
        })->count();

        // Overdue tasks
        $overdueTasks = Task::whereDate('due_date', '<', now())
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id())
                    ->whereNotIn('status_id', [3]); // Not completed
            })->count();

        // Completed tasks (this month)
        $completedTasks = Task::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status_id', [4]); // 3 = Completed
        })

            // ->whereMonth('due_date', now()->month)
            ->count();

        // Calculate completion percentage
        $totalAssignedTasks = $activeTasks + $completedTasks;
        $completedPercentage = $totalAssignedTasks > 0 ? round(($completedTasks / $totalAssignedTasks) * 100) : 0;

        // Hours logged this week - This would need a separate model to track hours
        // For now, use a placeholder or estimate based on completed tasks
        $hoursLogged = $completedTasks * 2; // Assuming 2 hours per completed task

        // Get data needed for forms
        $priorities = Priority::all();
        $comments = Task::with('comments')->whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();
        $users = User::where('id', '!=', Auth::id())->get();


        return view('employee.calendar', compact(
            'activeTasks',
            'overdueTasks',
            'completedTasks',
            'completedPercentage',
            'hoursLogged',
            'priorities',
            'users',
            'comments'
        ));
    }
    public function dashboard()
    {
        $user = Auth::user();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get tasks in progress (status_id 1 = Pending, 2 = In Progress)
        $inProgressTasks = Task::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->whereIn('status_id', [1, 2]);
        })->count();

        // Get completed tasks (status_id 4 = Completed)
        $completedTasks = Task::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status_id', 4);
        })->count();

        // Calculate completion rate
        $totalTasks = Task::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // Get tasks by priority (excluding completed)
        $priorityTasks = [];
        $user = Auth::user();

        // Get all priority levels
        $priorities = Priority::all();

        foreach ($priorities as $priority) {
            $priorityTasks[$priority->name] = Task::whereHas('assignees', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('status_id', '!=', 4); // Exclude "Completed" tasks
            })
                ->with([
                    'priority',
                    'creator:id,name,email',
                    'tasks',
                ])
                ->where('priority_id', $priority->id)
                ->orderBy('due_date', 'asc')
                ->limit(3)
                ->get();
        }

        // Get upcoming deadlines (next 30 days)
        $upcomingDeadlines = Task::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status_id', '!=', 4)
                ->whereBetween('due_date', [now(), now()->addDays(30)]);
        })->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        // Get monthly tasks
        $monthlyTasks = Task::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereYear('due_date', $currentYear)
            ->whereMonth('due_date', $currentMonth)
            ->orderBy('due_date', 'asc')
            ->get();

        return view('employee.dashboard', compact(
            'inProgressTasks',
            'completedTasks',
            'completionRate',
            'priorityTasks',
            'upcomingDeadlines',
            'monthlyTasks',
            'priorities',
            'currentMonth',
            'currentYear'
        ));
    }
}