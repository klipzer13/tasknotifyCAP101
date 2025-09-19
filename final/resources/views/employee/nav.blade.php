<nav class="top-navbar navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 px-3 mb-4 sticky-top">
    <div class="container-fluid d-flex justify-content-between align-items-center p-0">
        <!-- Left side - Toggle button and Brand -->
        <div class="d-flex align-items-center">
            <!-- Hamburger menu - only visible on mobile -->
            <button class="sidebar-collapse-btn btn btn-link text-dark p-0 me-2 me-md-3 d-lg-none" id="sidebarToggle">
                <i class="fas fa-bars fs-4"></i>
            </button>
            <span class="navbar-brand fw-bold text-primary ms-1 ms-md-2" id="adminGreeting">Admin Panel</span>
        </div>
        
        <!-- Right side - Navigation and User Info -->
        <div class="d-flex align-items-center">
            <!-- Notification and User Profile -->
            <div class="d-flex align-items-center ms-2 ms-lg-0">
                <!-- Notification -->
                <div class="position-relative me-2 me-lg-3">
                    <button class="btn btn-link text-dark p-0 position-relative">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    </button>
                </div>
                
                <!-- User Profile -->
                <div class="d-flex align-items-center ms-2 ms-lg-3 border-start ps-2 ps-lg-3">
                    <img src="{{ Auth::user()->avatar_url ?? asset('storage/profile/avatars/profile.png') }}" 
                         alt="User Profile" 
                         class="rounded-circle me-2 border border-2 border-primary"
                         width="40"
                         height="40">
                    <div class="d-none d-md-inline">
                        <div class="fw-bold text-dark">{{ ucwords(strtolower(Auth::user()->name)) }}</div>
                        <div class="small text-muted">Employee</div>
                    </div>
                    <!-- Show only name on small screens -->
                    <div class="d-inline d-md-none">
                        <div class="fw-bold text-dark">{{ explode(' ', ucwords(strtolower(Auth::user()->name)))[0] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    .top-navbar {
        transition: all 0.3s ease;
    }
    
    .nav-link {
        transition: color 0.2s;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
    }
    
    .nav-link:hover {
        color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .nav-link.active {
        color: #0d6efd !important;
        font-weight: 500;
    }
    
    .sidebar-collapse-btn:hover {
        transform: scale(1.1);
    }
    
    /* Mobile specific styles */
    @media (max-width: 575.98px) {
        .top-navbar {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .navbar-brand {
            font-size: 1rem;
        }
        .border-start {
            border-left: none !important;
        }
    }
</style>

<script>
    // Function to update greeting based on time of day
    function updateGreeting() {
        const greetingElement = document.getElementById('adminGreeting');
        const hour = new Date().getHours();
        let greeting;
        
        if (hour < 12) {
            greeting = 'Good Morning';
        } else if (hour < 18) {
            greeting = 'Good Afternoon';
        } else {
            greeting = 'Good Evening';
        }
        
        greetingElement.textContent = `${greeting}`;
    }

    // Update greeting on page load and resize
    document.addEventListener('DOMContentLoaded', function() {
        updateGreeting();
    });
    
    // Optional: Update greeting every minute in case page stays open for long
    setInterval(updateGreeting, 60000);
</script>