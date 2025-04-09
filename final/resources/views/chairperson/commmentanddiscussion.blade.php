@extends('genview')
@section('title', 'Task Discussions')

@section('content')
    <style>
        .discussions-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            padding: 30px;
            margin-bottom: 30px;
            border: none;
        }

        .section-header {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .section-header h4 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-header h4 i {
            margin-right: 10px;
        }

        .discussion-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .discussion-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
        }

        .discussion-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.1);
            border-bottom: 3px solid var(--primary-color);
        }

        .comment-card {
            border-radius: 12px;
            border: 1px solid #eee;
            margin-bottom: 20px;
            transition: all 0.3s;
            background-color: white;
        }

        .comment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .comment-header {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comment-user {
            display: flex;
            align-items: center;
        }

        .comment-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comment-user-info h5 {
            margin-bottom: 0;
            font-size: 1rem;
        }

        .comment-user-info small {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .comment-time {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .comment-body {
            padding: 20px;
        }

        .comment-text {
            color: #495057;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .comment-task {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .comment-task-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background-color: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: var(--primary-color);
        }

        .comment-task-info h6 {
            margin-bottom: 2px;
            font-size: 0.95rem;
        }

        .comment-task-info small {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .comment-actions {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .comment-reply-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .comment-reply-btn:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        .comment-reply-btn i {
            margin-right: 5px;
        }

        .reply-form {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #eee;
        }

        .replies-container {
            margin-left: 30px;
            border-left: 2px solid #eee;
            padding-left: 20px;
        }

        .notification-badge {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .unread-comment {
            border-left: 3px solid var(--primary-color);
            background-color: #f0f7ff;
        }

        .priority-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .priority-high {
            background-color: #ffebee;
            color: #ff6b6b;
        }

        .priority-medium {
            background-color: #fff8e1;
            color: #ffb74d;
        }

        .priority-low {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status-in-progress {
            background-color: #fff3e0;
            color: #fb8c00;
        }

        .status-completed {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .notification-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 15px;
        }

        .empty-state h5 {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #adb5bd;
            max-width: 400px;
            margin: 0 auto;
        }
    </style>

    <div class="main-content">
        @if(session('success'))
            <div class="notification-toast alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session(key: 'success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="top-nav d-flex justify-content-between align-items-center mb-4">
            <button class="sidebar-collapse-btn" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-flex align-items-center">
                <div class="position-relative me-3">
                    <i class="fas fa-bell fs-5"></i>
                    <span class="notification-badge">3</span>
                </div>
                <div class="user-profile">
                    <img src="{{ Auth::user()->avatar_url ?? asset('storage/profile/avatars/profile.png') }}" alt="User Profile" class="rounded-circle"
                        width="40">
                    <span>{{ ucwords(strtolower(Auth::user()->name)) }}</span>
                </div>
            </div>
        </div>

        <!-- Comments & Discussions Content -->
        <div class="discussions-container">
            <div class="section-header">
                <h4><i class="fas fa-comments"></i> Task Discussions</h4>
            </div>

            <ul class="nav nav-tabs discussion-tabs" id="discussionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-comments-tab" data-bs-toggle="tab" data-bs-target="#all-comments" type="button" role="tab">
                        All Comments
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="unread-tab" data-bs-toggle="tab" data-bs-target="#unread-comments" type="button" role="tab">
                        Unread
                        <span class="notification-badge">5</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="mentions-tab" data-bs-toggle="tab" data-bs-target="#mentions" type="button" role="tab">
                        Mentions
                        <span class="notification-badge">2</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="my-comments-tab" data-bs-toggle="tab" data-bs-target="#my-comments" type="button" role="tab">
                        My Responses
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="discussionTabsContent">
                <!-- All Comments Tab -->
                <div class="tab-pane fade show active" id="all-comments" role="tabpanel">
                    <div class="comment-card">
                        <div class="comment-header">
                            <div class="comment-user">
                                <img src="https://ui-avatars.com/api/?name=Sarah+J" alt="Sarah Johnson">
                                <div class="comment-user-info">
                                    <h5>Sarah Johnson</h5>
                                    <small>Finance Department</small>
                                </div>
                            </div>
                            <div class="comment-time">2 hours ago</div>
                        </div>
                        <div class="comment-body">
                            <div class="comment-task">
                                <div class="comment-task-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="comment-task-info">
                                    <h6>Annual Report Preparation <span class="priority-badge priority-high">High</span></h6>
                                    <small>Due: May 15, 2023 • <span class="status-badge status-in-progress">In Progress</span></small>
                                </div>
                            </div>
                            <p class="comment-text">
                                I've completed the financial statements section of the annual report. Attached is the draft for your review. Please let me know if you'd like any changes before I proceed with the analysis section.
                            </p>
                            <div class="comment-actions">
                                <button class="comment-reply-btn" onclick="toggleReplyForm(this)">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                            </div>
                            <div class="reply-form" style="display: none;">
                                <textarea class="form-control mb-2" rows="3" placeholder="Write your reply..."></textarea>
                                <button class="btn btn-sm btn-primary">Post Reply</button>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleReplyForm(this)">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <div class="comment-card unread-comment">
                        <div class="comment-header">
                            <div class="comment-user">
                                <img src="https://ui-avatars.com/api/?name=Michael+C" alt="Michael Chen">
                                <div class="comment-user-info">
                                    <h5>Michael Chen</h5>
                                    <small>Marketing Department</small>
                                </div>
                            </div>
                            <div class="comment-time">Yesterday</div>
                        </div>
                        <div class="comment-body">
                            <div class="comment-task">
                                <div class="comment-task-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="comment-task-info">
                                    <h6>Q2 Marketing Campaign <span class="priority-badge priority-medium">Medium</span></h6>
                                    <small>Due: June 1, 2023 • <span class="status-badge status-pending">Pending Approval</span></small>
                                </div>
                            </div>
                            <p class="comment-text">
                                @{{ Auth::user()->name }} I need your approval on the budget allocation for the Q2 campaign. I've attached the proposed breakdown. The digital ads portion is higher this quarter due to the product launch.
                            </p>
                            <div class="comment-actions">
                                <button class="comment-reply-btn" onclick="toggleReplyForm(this)">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                            </div>
                            <div class="reply-form" style="display: none;">
                                <textarea class="form-control mb-2" rows="3" placeholder="Write your reply..."></textarea>
                                <button class="btn btn-sm btn-primary">Post Reply</button>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleReplyForm(this)">Cancel</button>
                            </div>

                            <div class="replies-container">
                                <div class="comment-card">
                                    <div class="comment-header">
                                        <div class="comment-user">
                                            <img src="{{ Auth::user()->avatar_url ?? asset('storage/profile/avatars/profile.png') }}" alt="You">
                                            <div class="comment-user-info">
                                                <h5>You</h5>
                                                <small>Chairman</small>
                                            </div>
                                        </div>
                                        <div class="comment-time">12 hours ago</div>
                                    </div>
                                    <div class="comment-body">
                                        <p class="comment-text">
                                            The budget looks reasonable overall, but I'd like to see more allocation towards the influencer partnerships. Can you adjust and resubmit?
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="comment-card">
                        <div class="comment-header">
                            <div class="comment-user">
                                <img src="https://ui-avatars.com/api/?name=Robert+K" alt="Robert Kim">
                                <div class="comment-user-info">
                                    <h5>Robert Kim</h5>
                                    <small>IT Department</small>
                                </div>
                            </div>
                            <div class="comment-time">3 days ago</div>
                        </div>
                        <div class="comment-body">
                            <div class="comment-task">
                                <div class="comment-task-icon">
                                    <i class="fas fa-server"></i>
                                </div>
                                <div class="comment-task-info">
                                    <h6>Server Migration <span class="priority-badge priority-low">Low</span></h6>
                                    <small>Due: May 30, 2023 • <span class="status-badge status-completed">Completed</span></small>
                                </div>
                            </div>
                            <p class="comment-text">
                                The server migration has been completed successfully with zero downtime. All systems are functioning normally. I've attached the migration report and performance metrics.
                            </p>
                            <div class="comment-actions">
                                <button class="comment-reply-btn" onclick="toggleReplyForm(this)">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                            </div>
                            <div class="reply-form" style="display: none;">
                                <textarea class="form-control mb-2" rows="3" placeholder="Write your reply..."></textarea>
                                <button class="btn btn-sm btn-primary">Post Reply</button>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleReplyForm(this)">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Unread Comments Tab -->
                <div class="tab-pane fade" id="unread-comments" role="tabpanel">
                    <!-- Content would be loaded dynamically -->
                    <div class="comment-card unread-comment">
                        <div class="comment-header">
                            <div class="comment-user">
                                <img src="https://ui-avatars.com/api/?name=Emily+W" alt="Emily Wong">
                                <div class="comment-user-info">
                                    <h5>Emily Wong</h5>
                                    <small>Marketing Department</small>
                                </div>
                            </div>
                            <div class="comment-time">1 hour ago</div>
                        </div>
                        <div class="comment-body">
                            <div class="comment-task">
                                <div class="comment-task-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="comment-task-info">
                                    <h6>Social Media Analytics <span class="priority-badge priority-medium">Medium</span></h6>
                                    <small>Due: May 20, 2023 • <span class="status-badge status-in-progress">In Progress</span></small>
                                </div>
                            </div>
                            <p class="comment-text">
                                @{{ Auth::user()->name }} The Q1 social media metrics show a 25% increase in engagement but lower conversion than expected. Should we adjust our strategy or give it more time?
                            </p>
                            <div class="comment-actions">
                                <button class="comment-reply-btn" onclick="toggleReplyForm(this)">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                                <button class="comment-reply-btn ms-2" onclick="markAsRead(this)">
                                    <i class="fas fa-check"></i> Mark as read
                                </button>
                            </div>
                            <div class="reply-form" style="display: none;">
                                <textarea class="form-control mb-2" rows="3" placeholder="Write your reply..."></textarea>
                                <button class="btn btn-sm btn-primary">Post Reply</button>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleReplyForm(this)">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <div class="comment-card unread-comment">
                        <div class="comment-header">
                            <div class="comment-user">
                                <img src="https://ui-avatars.com/api/?name=David+M" alt="David Miller">
                                <div class="comment-user-info">
                                    <h5>David Miller</h5>
                                    <small>Operations Department</small>
                                </div>
                            </div>
                            <div class="comment-time">4 hours ago</div>
                        </div>
                        <div class="comment-body">
                            <div class="comment-task">
                                <div class="comment-task-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="comment-task-info">
                                    <h6>Supply Chain Optimization <span class="priority-badge priority-high">High</span></h6>
                                    <small>Due: May 10, 2023 • <span class="status-badge status-in-progress">In Progress</span></small>
                                </div>
                            </div>
                            <p class="comment-text">
                                We've identified potential cost savings in the logistics network, but it would require renegotiating contracts with two of our main suppliers. Need your approval to proceed.
                            </p>
                            <div class="comment-actions">
                                <button class="comment-reply-btn" onclick="toggleReplyForm(this)">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                                <button class="comment-reply-btn ms-2" onclick="markAsRead(this)">
                                    <i class="fas fa-check"></i> Mark as read
                                </button>
                            </div>
                            <div class="reply-form" style="display: none;">
                                <textarea class="form-control mb-2" rows="3" placeholder="Write your reply..."></textarea>
                                <button class="btn btn-sm btn-primary">Post Reply</button>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleReplyForm(this)">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mentions Tab -->
                <div class="tab-pane fade" id="mentions" role="tabpanel">
                    <!-- Content would be loaded dynamically -->
                    <div class="comment-card unread-comment">
                        <div class="comment-header">
                            <div class="comment-user">
                                <img src="https://ui-avatars.com/api/?name=Michael+C" alt="Michael Chen">
                                <div class="comment-user-info">
                                    <h5>Michael Chen</h5>
                                    <small>Finance Department</small>
                                </div>
                            </div>
                            <div class="comment-time">Yesterday</div>
                        </div>
                        <div class="comment-body">
                            <div class="comment-task">
                                <div class="comment-task-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="comment-task-info">
                                    <h6>Q2 Marketing Campaign <span class="priority-badge priority-medium">Medium</span></h6>
                                    <small>Due: June 1, 2023 • <span class="status-badge status-pending">Pending Approval</span></small>
                                </div>
                            </div>
                            <p class="comment-text">
                                @{{ Auth::user()->name }} I need your approval on the budget allocation for the Q2 campaign. I've attached the proposed breakdown. The digital ads portion is higher this quarter due to the product launch.
                            </p>
                            <div class="comment-actions">
                                <button class="comment-reply-btn" onclick="toggleReplyForm(this)">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                                <button class="comment-reply-btn ms-2" onclick="markAsRead(this)">
                                    <i class="fas fa-check"></i> Mark as read
                                </button>
                            </div>
                            <div class="reply-form" style="display: none;">
                                <textarea class="form-control mb-2" rows="3" placeholder="Write your reply..."></textarea>
                                <button class="btn btn-sm btn-primary">Post Reply</button>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleReplyForm(this)">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <div class="comment-card">
                        <div class="comment-header">
                            <div class="comment-user">
                                <img src="https://ui-avatars.com/api/?name=Sarah+J" alt="Sarah Johnson">
                                <div class="comment-user-info">
                                    <h5>Sarah Johnson</h5>
                                    <small>Finance Department</small>
                                </div>
                            </div>
                            <div class="comment-time">1 week ago</div>
                        </div>
                        <div class="comment-body">
                            <div class="comment-task">
                                <div class="comment-task-icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div class="comment-task-info">
                                    <h6>Audit Preparation <span class="priority-badge priority-high">High</span></h6>
                                    <small>Due: Completed • <span class="status-badge status-completed">Completed</span></small>
                                </div>
                            </div>
                            <p class="comment-text">
                                @{{ Auth::user()->name }} Following up on our discussion - the auditors have signed off on all financial statements with no major findings. The final report has been uploaded to the system.
                            </p>
                            <div class="comment-actions">
                                <button class="comment-reply-btn" onclick="toggleReplyForm(this)">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                            </div>
                            <div class="reply-form" style="display: none;">
                                <textarea class="form-control mb-2" rows="3" placeholder="Write your reply..."></textarea>
                                <button class="btn btn-sm btn-primary">Post Reply</button>
                                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleReplyForm(this)">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- My Responses Tab -->
                <div class="tab-pane fade" id="my-comments" role="tabpanel">
                    <!-- Content would be loaded dynamically -->
                    <div class="empty-state">
                        <i class="fas fa-comment-slash"></i>
                        <h5>No Responses Yet</h5>
                        <p>When you reply to comments on tasks, your responses will appear here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide notification after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const notification = document.querySelector('.notification-toast');
            if (notification) {
                setTimeout(() => {
                    notification.classList.remove('show');
                    notification.classList.add('hide');
                }, 5000);
            }
        });

        function toggleReplyForm(button) {
            const replyForm = button.closest('.comment-actions').nextElementSibling;
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        }

        function markAsRead(button) {
            const commentCard = button.closest('.comment-card');
            commentCard.classList.remove('unread-comment');
            
            // In a real app, you would send an AJAX request to mark as read
            // and update the notification badge count
            updateUnreadCount();
        }

        function updateUnreadCount() {
            // This would be connected to your backend in a real app
            const unreadBadges = document.querySelectorAll('.notification-badge');
            unreadBadges.forEach(badge => {
                const currentCount = parseInt(badge.textContent);
                if (currentCount > 0) {
                    badge.textContent = currentCount - 1;
                }
            });
        }
    </script>
@endsection