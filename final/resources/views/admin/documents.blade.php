@extends('genview')
@php
    if (!function_exists('formatFileSize')) {
        function formatFileSize($bytes, $decimals = 2)
        {
            if ($bytes === 0)
                return '0 Bytes';
            $k = 1024;
            $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            $i = floor(log($bytes) / log($k));
            return round($bytes / pow($k, $i), $decimals) . ' ' . $sizes[$i];
        }
    }
@endphp

@section('title', 'Document Management')

@section('content')
    <style>
        :root {
            --primary-color: #4b6cb7;
            --secondary-color: #182848;
        }

        .documents-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }

        .documents-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin-bottom: 25px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-area:hover {
            border-color: var(--primary-color);
            background-color: #f8faff;
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .file-type-badge {
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .file-type-badge.pdf {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .file-type-badge.doc {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .file-type-badge.img {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .file-type-badge.zip {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .file-type-badge.other {
            background-color: #e0e0e0;
            color: #424242;
        }

        .file-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .file-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .file-actions {
            display: flex;
            justify-content: flex-end;
        }

        .file-actions .btn {
            margin-left: 8px;
            padding: 5px 10px;
        }

        .folder-breadcrumb {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .folder-breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
            margin: 0 5px;
        }

        .folder-breadcrumb a:hover {
            text-decoration: underline;
        }

        .folder-breadcrumb .separator {
            color: #6c757d;
            margin: 0 5px;
        }

        .upload-btn {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .file-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .file-table thead th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #eee;
        }

        .file-table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .file-table tbody tr:last-child td {
            border-bottom: none;
        }

        .file-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .file-icon {
            font-size: 1.2rem;
            margin-right: 10px;
            width: 24px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .documents-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .file-actions {
                margin-top: 10px;
                justify-content: flex-start;
            }

            .file-actions .btn {
                margin-left: 0;
                margin-right: 8px;
            }

            .file-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>

    <div class="main-content">
        <!-- Top Navigation -->
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

        <!-- Documents Container -->
        <div class="documents-container">
            <!-- Documents Header -->
            <div class="documents-header">
                <h4><i class="fas fa-folder me-2"></i> Document Management</h4>
                <button class="btn upload-btn" type="hidden" id="uploadTrigger">
                    <i class="fas fa-upload me-2"></i> Upload Files
                </button>
            </div>

            <!-- Folder Navigation -->
            <!-- <div class="folder-breadcrumb">
                    <a href="#"><i class="fas fa-home"></i></a>
                    <span class="separator">/</span>
                    <span>All Attachments</span>
                </div> -->

            <!-- Upload Area -->
            <div class="upload-area" id="uploadArea" style="display: none;">
                <form id="uploadForm" action="{{ route('attachments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <h5>Drag & Drop Files Here</h5>
                    <p class="text-muted">or click to browse files</p>
                    <input type="file" id="fileUpload" name="files[]" multiple style="display: none;">
                    <input type="hidden" name="task_id" value="0"> <!-- Default or dynamic task ID -->
                    <button type="button" class="btn btn-outline-primary mt-3"
                        onclick="document.getElementById('fileUpload').click()">
                        Select Files
                    </button>
                    <div id="fileList" class="mt-3"></div>
                    <button type="submit" class="btn btn-primary mt-3" id="uploadSubmit" style="display: none;">
                        <i class="fas fa-upload me-2"></i> Upload Now
                    </button>
                </form>
            </div>

            <!-- View Toggle -->
            <div class="d-flex justify-content-end mb-3">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active" id="listViewBtn">
                        <i class="fas fa-list"></i> List
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="gridViewBtn">
                        <i class="fas fa-th-large"></i> Grid
                    </button>
                </div>
            </div>

            <!-- Files Table (List View) -->
            <div class="table-responsive" id="listView">
                <table class="file-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Uploaded</th>
                            <th>Uploaded By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attachments as $attachment)
                                            <tr>
                                                <td>
                                                    @php
                                                        $icon = match (true) {
                                                            str_contains($attachment->type, 'pdf') => 'fa-file-pdf text-danger',
                                                            str_contains($attachment->type, 'word') => 'fa-file-word text-primary',
                                                            str_contains($attachment->type, 'image') => 'fa-file-image text-success',
                                                            str_contains($attachment->type, 'zip') => 'fa-file-archive text-warning',
                                                            default => 'fa-file-alt text-secondary'
                                                        };
                                                    @endphp
                                                    <i class="fas {{ $icon }} file-icon"></i>
                                                    {{ $attachment->filename }}
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeClass = match (true) {
                                                            str_contains($attachment->type, 'pdf') => 'pdf',
                                                            str_contains($attachment->type, 'word') => 'doc',
                                                            str_contains($attachment->type, 'image') => 'img',
                                                            str_contains($attachment->type, 'zip') => 'zip',
                                                            default => 'other'
                                                        };
                                                    @endphp
                                                    <span
                                                        class="file-type-badge {{ $badgeClass }}">{{ strtoupper(pathinfo($attachment->filename, PATHINFO_EXTENSION)) }}</span>
                                                </td>
                                                <td>{{ formatFileSize($attachment->size) }}</td>
                                                <td>{{ $attachment->created_at->format('M d, Y') }}</td>
                                                <td>{{ $attachment->uploader->name ?? 'System' }}</td>
                                                <td>
                                                    <a href="{{ route('attachments.download', $attachment->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-secondary share-btn"
                                                        data-file-id="{{ $attachment->id }}">
                                                        <i class="fas fa-share"></i>
                                                    </button>
                                                    <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Files Grid (Hidden by default) -->
            <div class="row" id="gridView" style="display: none;">
                @foreach($attachments as $attachment)
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="file-card">
                                    <div class="d-flex justify-content-between">
                                        @php
                                            $icon = match (true) {
                                                str_contains($attachment->type, 'pdf') => 'fa-file-pdf text-danger',
                                                str_contains($attachment->type, 'word') => 'fa-file-word text-primary',
                                                str_contains($attachment->type, 'image') => 'fa-file-image text-success',
                                                str_contains($attachment->type, 'zip') => 'fa-file-archive text-warning',
                                                default => 'fa-file-alt text-secondary'
                                            };
                                        @endphp
                                        <i class="fas {{ $icon }}" style="font-size: 2rem;"></i>
                                        <span class="file-type-badge {{ $badgeClass ?? 'other' }}">
                                            {{ strtoupper(pathinfo($attachment->filename, PATHINFO_EXTENSION)) }}
                                        </span>
                                    </div>
                                    <h6 class="mt-2 mb-1">{{ $attachment->filename }}</h6>
                                    <p class="text-muted small mb-2">{{ formatFileSize($attachment->size) }}</p>
                                    <p class="small text-muted">Uploaded: {{ $attachment->created_at->format('M d') }}</p>
                                    <div class="file-actions">
                                        <a href="{{ route('attachments.download', $attachment->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-secondary share-btn" data-file-id="{{ $attachment->id }}">
                                            <i class="fas fa-share"></i>
                                        </button>
                                        <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav class="mt-4 d-flex justify-content-center">
                <ul class="pagination pagination-sm">
                    @if ($attachments->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $attachments->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>
                    @endif

                    @foreach ($attachments->getUrlRange(1, $attachments->lastPage()) as $page => $url)
                        @if ($page == $attachments->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    @if ($attachments->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $attachments->nextPageUrl() }}" rel="next">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">&raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

    <!-- File Preview Modal -->
    <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-hidden="true">
        <!-- [Keep your existing preview modal] -->
        <!-- ... -->
    </div>

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="shareForm">
                        <div class="mb-3">
                            <label class="form-label">File</label>
                            <input type="text" class="form-control" id="shareFileName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Share with</label>
                            <select class="form-select" id="shareUserId" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permission</label>
                            <select class="form-select" id="sharePermission" required>
                                <option value="view">Can View</option>
                                <option value="edit">Can Edit</option>
                                <option value="download">Can Download</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmShare">Share</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.getElementById('fileUpload').addEventListener('change', function (e) {
            const files = e.target.files;
            const fileList = document.getElementById('fileList');
            const uploadSubmit = document.getElementById('uploadSubmit');

            fileList.innerHTML = '';

            if (files.length > 0) {
                uploadSubmit.style.display = 'inline-block';

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'd-flex justify-content-between align-items-center mb-2';
                    fileItem.innerHTML = `
                                <span>${file.name}</span>
                                <small class="text-muted">${formatFileSize(file.size)}</small>
                            `;
                    fileList.appendChild(fileItem);
                }
            } else {
                uploadSubmit.style.display = 'none';
            }
        });

        // Form submission with progress
        document.getElementById('uploadForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const uploadArea = document.getElementById('uploadArea');

            axios.post(this.action, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: function (progressEvent) {
                    const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    console.log(percentCompleted);
                    // You could add a progress bar here
                }
            })
                .then(response => {
                    alert('Files uploaded successfully!');
                    uploadArea.style.display = 'none';
                    window.location.reload();
                })
                .catch(error => {
                    alert('Error uploading files: ' + error.response.data.message);
                });
        });

        // Share functionality
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const fileId = this.getAttribute('data-file-id');
                const fileName = this.closest('tr').querySelector('td').textContent.trim();

                document.getElementById('shareFileName').value = fileName;
                document.getElementById('shareForm').setAttribute('data-file-id', fileId);

                const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
                shareModal.show();
            });
        });

        document.getElementById('confirmShare').addEventListener('click', function () {
            const fileId = document.getElementById('shareForm').getAttribute('data-file-id');
            const userId = document.getElementById('shareUserId').value;
            const permission = document.getElementById('sharePermission').value;

            axios.post('/api/share-file', {
                file_id: fileId,
                user_id: userId,
                permission: permission
            })
                .then(response => {
                    alert('File shared successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('shareModal')).hide();
                })
                .catch(error => {
                    alert('Error sharing file: ' + error.response.data.message);
                });
        });

        // Helper function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        }
        // Toggle upload area
        document.getElementById('uploadTrigger').addEventListener('click', function () {
            const uploadArea = document.getElementById('uploadArea');
            uploadArea.style.display = uploadArea.style.display === 'none' ? 'block' : 'none';
        });

        // Handle file upload
        document.getElementById('fileUpload').addEventListener('change', function (e) {
            const files = e.target.files;
            if (files.length > 0) {
                // Here you would typically upload files to your server
                console.log('Files selected for upload:', files);

                // Show success message
                alert(`${files.length} file(s) selected for upload`);

                // Hide upload area after selection
                document.getElementById('uploadArea').style.display = 'none';

                // You would typically refresh the file list here after upload
            }
        });

        // Drag and drop functionality
        const uploadArea = document.getElementById('uploadArea');

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim();
            uploadArea.style.backgroundColor = '#f0f4ff';
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.style.borderColor = '#ddd';
            uploadArea.style.backgroundColor = '';
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = '#ddd';
            uploadArea.style.backgroundColor = '';

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('fileUpload').files = files;
                console.log('Files dropped for upload:', files);
                alert(`${files.length} file(s) dropped for upload`);
            }
        });

        // Toggle between list and grid view
        document.getElementById('listViewBtn').addEventListener('click', function () {
            this.classList.add('active');
            document.getElementById('gridViewBtn').classList.remove('active');
            document.getElementById('listView').style.display = 'block';
            document.getElementById('gridView').style.display = 'none';
        });

        document.getElementById('gridViewBtn').addEventListener('click', function () {
            this.classList.add('active');
            document.getElementById('listViewBtn').classList.remove('active');
            document.getElementById('listView').style.display = 'none';
            document.getElementById('gridView').style.display = 'flex';
        });

        // File preview functionality
        function previewFile(fileUrl, fileType) {
            const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            const pdfPreview = document.getElementById('pdfPreview');
            const imagePreview = document.getElementById('imagePreview');
            const unsupportedPreview = document.getElementById('unsupportedPreview');

            // Reset all previews
            pdfPreview.style.display = 'none';
            imagePreview.style.display = 'none';
            unsupportedPreview.style.display = 'none';

            // Show appropriate preview
            if (fileType === 'pdf') {
                pdfPreview.style.display = 'block';
                pdfPreview.querySelector('iframe').src = fileUrl;
            } else if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                imagePreview.style.display = 'block';
                imagePreview.querySelector('img').src = fileUrl;
            } else {
                unsupportedPreview.style.display = 'block';
            }

            // Set modal title
            document.getElementById('filePreviewModalLabel').textContent = `Preview: ${fileUrl.split('/').pop()}`;

            modal.show();
        }

        // Example of attaching preview to files (would be dynamic in real app)
        document.querySelectorAll('.file-table tbody tr').forEach(row => {
            row.addEventListener('click', function (e) {
                // Don't trigger if clicking on buttons
                if (e.target.tagName === 'BUTTON' || e.target.closest('button')) {
                    return;
                }

                const fileIcon = this.querySelector('.file-icon');
                let fileType = '';

                if (fileIcon.classList.contains('fa-file-pdf')) {
                    fileType = 'pdf';
                } else if (fileIcon.classList.contains('fa-file-image')) {
                    fileType = 'png';
                }

                // In a real app, you would use the actual file URL
                previewFile('https://example.com/files/' + this.querySelector('td').textContent.trim(), fileType);
            });
        });
    </script>

@endsection