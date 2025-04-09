@extends('chairperson.genchair')
@section('title', 'Activity Log')

@section('content')
    <div class="main-content">
        <div class="top-nav d-flex justify-content-between align-items-center mb-4">
            <h2>Activity Log</h2>
            <div>
                <select class="form-select form-select-sm" style="width: auto; display: inline-block;">
                    <option>Today</option>
                    <option>This Week</option>
                    <option selected>This Month</option>
                </select>
            </div>
        </div>

        <div class="dashboard-container">
            <div class="timeline">
                @foreach($recentActivity as $activity)
                <div class="timeline-item mb-4">
                    <div class="timeline-item-marker">
                        <div class="timeline-item-marker-indicator bg-{{ $activity->event == 'created' ? 'primary' : ($activity->event == 'updated' ? 'info' : 'warning') }}"></div>
                    </div>
                    <div class="timeline-item-content">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <img src="{{ $activity->user->avatar_url ?? asset('images/default-avatar.png') }}" 
                                     alt="{{ $activity->user->name ??'N/A'}}" 
                                     class="assignee me-3">
                                <div>
                                    <strong>{{ $activity->user->name  ??'N/A' }}</strong>
                                    <div class="text-muted small">{{ $activity->description }}</div>
                                </div>
                            </div>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                        
                        @if($activity->subject_type == 'App\Models\Task')
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">{{ $activity->subject->title }}</h5>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="priority-badge priority-{{ strtolower($activity->subject->priority->name) }} me-2">
                                        {{ $activity->subject->priority->name }}
                                    </span>
                                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($activity->subject->status->name)) }}">
                                        {{ $activity->subject->status->name }}
                                    </span>
                                </div>
                                <p class="card-text text-muted small">{{ Str::limit($activity->subject->description, 100) }}</p>
                                <a href="{{ route('tasks.review', $activity->subject->id) }}" class="btn btn-sm btn-outline-primary">
                                    View Task
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $recentActivity->links() }}
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 1rem;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        .timeline-item-marker {
            position: absolute;
            left: -1.5rem;
            width: 2.5rem;
            text-align: center;
        }
        .timeline-item-marker-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #dee2e6;
        }
        .timeline-item-content {
            padding-left: 2rem;
        }
    </style>
@endsection