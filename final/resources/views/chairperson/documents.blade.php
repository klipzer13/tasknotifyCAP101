@extends('chairperson.genchair')

@section('title', 'Document Management')

@section('content')
    <style>
        /* Modern Color Scheme with Vibrant Accents */
        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        }

        /* Animation Keyframes */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(67, 97, 238, 0); }
            100% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0); }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes ripple {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(2.5); opacity: 0; }
        }

        /* Main Container with Glass Morphism Effect */
        .documents-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            padding: 30px;
            margin-bottom: 30px;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            animation: fadeIn 0.6s ease-out forwards;
            transition: all 0.3s ease;
        }

        .documents-container:hover {
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            transform: translateY(-2px);
        }

        /* Header with Floating Animation */
        .documents-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            animation: slideInRight 0.5s ease-out;
        }

        .documents-header h4 {
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            font-size: 1.8rem;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .documents-header h4 i {
            margin-right: 12px;
            color: var(--primary);
        }

        /* Enhanced Search Box with Floating Effect */
        .search-box {
            position: relative;
            width: 320px;
            transition: all 0.3s ease;
        }

        .search-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.1);
        }

        .search-box .input-group-text {
            background: var(--primary-light);
            border: none;
            color: var(--primary);
            border-radius: 12px 0 0 12px !important;
        }

        .search-box .form-control {
            border: none;
            background: var(--primary-light);
            padding: 14px 20px;
            border-radius: 0 12px 12px 0 !important;
            transition: all 0.3s ease;
        }

        .search-box .form-control:focus {
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.2);
            background: white;
        }

        /* Employee Avatar with Hover Effect */
        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-right: 12px;
        }

        .employee-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Table Styles with Floating Rows */
        .document-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            margin-top: 20px;
        }

        .document-table thead th {
            background: var(--primary);
            color: white;
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
            border: none;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .document-table thead th:first-child {
            border-top-left-radius: 14px;
            border-bottom-left-radius: 14px;
        }

        .document-table thead th:last-child {
            border-top-right-radius: 14px;
            border-bottom-right-radius: 14px;
        }

        .document-table tbody td {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            vertical-align: middle;
            background: white;
            transition: all 0.3s ease;
        }

        .document-table tbody tr {
            opacity: 0;
            animation: fadeIn 0.4s ease-out forwards;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            margin-bottom: 10px;
        }

        .document-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
        .document-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
        .document-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
        .document-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
        .document-table tbody tr:nth-child(5) { animation-delay: 0.5s; }
        .document-table tbody tr:nth-child(6) { animation-delay: 0.6s; }
        .document-table tbody tr:nth-child(7) { animation-delay: 0.7s; }

        .document-table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .document-table tbody tr:hover td {
            background: var(--primary-light);
        }

        .document-table tbody td:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .document-table tbody td:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* Enhanced Progress Bar Styles */
        .progress-container {
            width: 100%;
            height: 8px;
            background-color: #f0f0f0;
            border-radius: 4px;
            margin-top: 8px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--primary), var(--success));
            transition: width 0.8s cubic-bezier(0.65, 0, 0.35, 1);
            position: relative;
            width: 0;
        }

        .progress-bar.animated {
            animation: progressAnimation 1.5s ease-out forwards;
        }

        @keyframes progressAnimation {
            from { width: 0; }
            to { width: var(--progress-width); }
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0.2) 0%,
                rgba(255, 255, 255, 0.6) 50%,
                rgba(255, 255, 255, 0.2) 100%
            );
            background-size: 200% 100%;
            animation: shimmer 2s infinite linear;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Enhanced Status Badges with Icons */
        .status-badge {
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .status-badge i {
            margin-right: 6px;
            font-size: 0.7rem;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-in-progress {
            background-color: #cce5ff;
            color: #004085;
            animation: pulse 2s infinite;
        }

        /* Document Type Chips */
        .document-type {
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 0.75rem;
            font-weight: 600;
            background-color: var(--primary-light);
            color: var(--primary);
            display: inline-block;
            transition: all 0.3s ease;
        }

        .document-type:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.1);
        }

        /* Responsive Table */
        @media (max-width: 992px) {
            .document-table {
                display: block;
                overflow-x: auto;
            }
            
            .search-box {
                width: 100%;
                margin-top: 15px;
            }
            
            .documents-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 768px) {
            .document-table thead {
                display: none;
            }
            
            .document-table tbody tr {
                display: block;
                margin-bottom: 20px;
                border: 1px solid rgba(0, 0, 0, 0.05);
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                animation: none !important;
                opacity: 1 !important;
            }
            
            .document-table tbody tr:hover {
                transform: none;
            }
            
            .document-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 15px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            }
            
            .document-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 15px;
                color: var(--gray);
                min-width: 120px;
            }
            
            .documents-container {
                padding: 20px;
            }
        }
    </style>

    <div class="main-content">
        <!-- Documents Container with Enhanced Glass Effect -->
        <div class="documents-container">
            <div class="documents-header">
                <h4><i class="fas fa-file-contract"></i> Document Management</h4>
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search documents..." id="searchDocuments">
                    </div>
                </div>
            </div>

            <!-- Document Tracking Table with Floating Rows -->
            <div class="table-responsive">
                <table class="document-table">
                    <thead>
                        <tr>
                            <th>Tracking No.</th>
                            <th>Employee</th>
                            <th>Document Type</th>
                            <th>Size</th>
                            <th>Assigned</th>
                            <th>Submitted</th>
                            <th>Completion</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="documentTableBody">
                        <!-- Sample data will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Enhanced sample data with employee images and more details
        const documentData = [
            {
                trackingNumber: 'DOC-2023-001',
                employeeName: 'John Smith',
                employeeImage: 'https://randomuser.me/api/portraits/men/32.jpg',
                documentType: 'Annual Report',
                documentSize: 1250,
                assignedDocuments: 5,
                submittedDocuments: 3,
                status: 'in-progress',
                dueDate: '2023-12-15'
            },
            {
                trackingNumber: 'DOC-2023-002',
                employeeName: 'Sarah Johnson',
                employeeImage: 'https://randomuser.me/api/portraits/women/44.jpg',
                documentType: 'Budget Proposal',
                documentSize: 850,
                assignedDocuments: 3,
                submittedDocuments: 3,
                status: 'completed',
                dueDate: '2023-11-30'
            },
            {
                trackingNumber: 'DOC-2023-003',
                employeeName: 'Michael Chen',
                employeeImage: 'https://randomuser.me/api/portraits/men/75.jpg',
                documentType: 'Security Audit',
                documentSize: 3200,
                assignedDocuments: 7,
                submittedDocuments: 2,
                status: 'pending',
                dueDate: '2024-01-20'
            },
            {
                trackingNumber: 'DOC-2023-004',
                employeeName: 'Emily Wilson',
                employeeImage: 'https://randomuser.me/api/portraits/women/68.jpg',
                documentType: 'Employee Handbook',
                documentSize: 1800,
                assignedDocuments: 4,
                submittedDocuments: 4,
                status: 'completed',
                dueDate: '2023-10-10'
            },
            {
                trackingNumber: 'DOC-2023-005',
                employeeName: 'David Rodriguez',
                employeeImage: 'https://randomuser.me/api/portraits/men/81.jpg',
                documentType: 'Process Documentation',
                documentSize: 950,
                assignedDocuments: 6,
                submittedDocuments: 1,
                status: 'pending',
                dueDate: '2024-02-05'
            },
            {
                trackingNumber: 'DOC-2023-006',
                employeeName: 'Lisa Thompson',
                employeeImage: 'https://randomuser.me/api/portraits/women/63.jpg',
                documentType: 'Client Proposal',
                documentSize: 2100,
                assignedDocuments: 2,
                submittedDocuments: 2,
                status: 'completed',
                dueDate: '2023-09-25'
            },
            {
                trackingNumber: 'DOC-2023-007',
                employeeName: 'Robert Kim',
                employeeImage: 'https://randomuser.me/api/portraits/men/90.jpg',
                documentType: 'Feature Spec',
                documentSize: 1750,
                assignedDocuments: 5,
                submittedDocuments: 3,
                status: 'in-progress',
                dueDate: '2023-12-30'
            }
        ];

        // Format file size function
        function formatFileSize(kb) {
            if (kb < 1024) return kb + ' KB';
            const mb = (kb / 1024).toFixed(1);
            return mb + ' MB';
        }

        // Calculate completion percentage with animation
        function calculateCompletion(assigned, submitted) {
            return Math.round((submitted / assigned) * 100);
        }

        // Get status badge with icon
        function getStatusBadge(status) {
            switch(status) {
                case 'completed':
                    return `<span class="status-badge status-completed">
                                <i class="fas fa-check-circle"></i> Completed
                            </span>`;
                case 'pending':
                    return `<span class="status-badge status-pending">
                                <i class="fas fa-clock"></i> Pending
                            </span>`;
                case 'in-progress':
                    return `<span class="status-badge status-in-progress">
                                <i class="fas fa-spinner"></i> In Progress
                            </span>`;
                default:
                    return '';
            }
        }

        // Format due date
        function formatDueDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        // Render the document table with animations
        function renderDocumentTable(data) {
            const tableBody = document.getElementById('documentTableBody');
            tableBody.innerHTML = '';
            
            data.forEach((doc, index) => {
                const completion = calculateCompletion(doc.assignedDocuments, doc.submittedDocuments);
                const dueDate = formatDueDate(doc.dueDate);
                
                const row = document.createElement('tr');
                row.style.animationDelay = `${index * 0.1}s`;
                row.innerHTML = `
                    <td data-label="Tracking No.">
                        <span class="fw-bold text-primary">${doc.trackingNumber}</span>
                    </td>
                    <td data-label="Employee">
                        <div class="d-flex align-items-center">
                            <img src="${doc.employeeImage}" alt="${doc.employeeName}" class="employee-avatar">
                            <div>
                                <div class="fw-semibold">${doc.employeeName}</div>
                                <small class="text-muted">Due ${dueDate}</small>
                            </div>
                        </div>
                    </td>
                    <td data-label="Document Type">
                        <span class="document-type">${doc.documentType}</span>
                    </td>
                    <td data-label="Size">${formatFileSize(doc.documentSize)}</td>
                    <td data-label="Assigned">${doc.assignedDocuments}</td>
                    <td data-label="Submitted">${doc.submittedDocuments}</td>
                    <td data-label="Completion">
                        <div class="fw-bold ${completion === 100 ? 'text-success' : completion > 50 ? 'text-primary' : 'text-warning'}">
                            ${completion}%
                        </div>
                    </td>
                    <td data-label="Status">
                        ${getStatusBadge(doc.status)}
                        <div class="progress-container">
                            <div class="progress-bar animated" style="--progress-width: ${completion}%"></div>
                        </div>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });

            // Animate progress bars after a short delay to allow DOM rendering
            setTimeout(() => {
                document.querySelectorAll('.progress-bar.animated').forEach(bar => {
                    bar.style.width = bar.style.getPropertyValue('--progress-width');
                });
            }, 100);
        }

        // Search functionality with debounce
        let searchTimeout;
        document.getElementById('searchDocuments').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = this.value.toLowerCase();
                const filteredData = documentData.filter(doc => 
                    doc.trackingNumber.toLowerCase().includes(searchTerm) ||
                    doc.employeeName.toLowerCase().includes(searchTerm) ||
                    doc.documentType.toLowerCase().includes(searchTerm)
                );
                
                renderDocumentTable(filteredData);
            }, 300);
        });

        // Initialize the table when page loads
        document.addEventListener('DOMContentLoaded', function() {
            renderDocumentTable(documentData);
            
            // Add hover effects to all progress bars
            document.querySelectorAll('.progress-bar').forEach(bar => {
                bar.addEventListener('mouseenter', function() {
                    this.style.transform = 'scaleY(1.3)';
                });
                
                bar.addEventListener('mouseleave', function() {
                    this.style.transform = 'scaleY(1)';
                });
            });
        });

        // Add animation to table rows on hover
        document.addEventListener('mouseover', function(e) {
            if (e.target.closest('.document-table tbody tr')) {
                const row = e.target.closest('tr');
                row.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.1)';
            }
        });

        document.addEventListener('mouseout', function(e) {
            if (e.target.closest('.document-table tbody tr')) {
                const row = e.target.closest('tr');
                row.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.03)';
            }
        });
    </script>
@endsection