@extends('layouts.primary')
@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary shadow-lg">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="text-white mb-2">
                                    <i class="fas fa-sticky-note me-2"></i>{{ $note->title }}
                                </h2>
                                <div class="d-flex align-items-center">
                                    <span class="topic-badge me-3">{{ $note->topic }}</span>
                                    <!-- @if($note->workspace)
                                        <span class="workspace-badge">{{ ucfirst($note->workspace) }}</span>
                                    @endif -->
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="/add-note?id={{ $note->id }}" class="btn btn-light btn-lg me-2">
                                    <i class="fas fa-edit me-2"></i>{{ __('Edit Note') }}
                                </a>
                                <button type="button" class="btn btn-outline-light btn-lg" onclick="deleteNote({{ $note->id }})">
                                    <i class="fas fa-trash me-2"></i>{{ __('Delete Note') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Note Content -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Tags Section -->
                        @php
                            $cleanTags = $note->clean_tags ?? [];
                        @endphp
                        @if(!empty($cleanTags) && count($cleanTags) > 0)
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3 text-muted">{{ __('Tags') }}</h6>
                                <div class="tags-container">
                                    @foreach($cleanTags as $tag)
                                        <span class="tag-item">{{ ucfirst(strtolower($tag)) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="note-content">
                            {!! $note->notes !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Author Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-muted">{{ __('Author') }}</h6>
                        <div class="d-flex align-items-center">
                            @if(!empty($users[$note->admin_id]->photo))
                                <img src="{{ asset('public/uploads/' . $users[$note->admin_id]->photo) }}" 
                                     alt="Author" 
                                     class="author-avatar me-3">
                            @else
                                <div class="author-avatar-placeholder me-3">
                                    @if(!empty($users[$note->admin_id]))
                                        {{ strtoupper(substr($users[$note->admin_id]->first_name, 0, 1)) }}{{ strtoupper(substr($users[$note->admin_id]->last_name, 0, 1)) }}
                    @endif
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-1">
                                    @if(isset($users[$note->admin_id]))
                                        {{ $users[$note->admin_id]->first_name }} {{ $users[$note->admin_id]->last_name }}
                                    @else
                                        Unknown Author
                                    @endif
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($note->created_at)->format('M j, Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
            </div>

                <!-- Cover Image -->
                        @if(!empty($note->cover_photo))
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <img src="{{ asset('public/uploads/' . $note->cover_photo) }}" 
                                 alt="Cover Photo" 
                                 class="img-fluid rounded">
                        </div>
                    </div>
                        @endif

                <!-- Attachments -->
                @if($note->attachments && count($note->attachments) > 0)
                    <div class="card shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 text-muted">{{ __('Attachments') }}</h6>
                            <div class="attachment-list">
                                @foreach($note->attachments as $attachment)
                                    <div class="attachment-item d-flex align-items-center p-2 border rounded mb-2">
                                        <i class="fas fa-file me-3 text-primary"></i>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium">{{ $attachment['name'] ?? 'Unknown File' }}</div>
                                            <small class="text-muted">{{ $note->getFormattedFileSize($attachment['size'] ?? 0) }}</small>
                                        </div>
                                        <a href="{{ asset('public/uploads/' . $attachment['path']) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           target="_blank">
                                            <i class="fas fa-download"></i>
                    </a>
                </div>
                                @endforeach
                            </div>
            </div>
        </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteNote(noteId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to recover this note!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#667eea',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#ffffff',
                customClass: {
                    popup: 'swal2-popup-custom',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom',
                    confirmButton: 'swal2-confirm-custom',
                    cancelButton: 'swal2-cancel-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/delete/note/' + noteId;
                }
            });
        }
    </script>

    <style>
        /* Consistent Color Scheme Variables */
        :root {
            --primary-color: #667eea;
            --primary-dark: #5a67d8;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --accent-dark: #ed64a6;
            --danger-color: #e53e3e;
            --danger-light: #fed7d7;
            --success-color: #38a169;
            --warning-color: #d69e2e;
            --info-color: #3182ce;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --text-muted: #a0aec0;
            --bg-light: #f7fafc;
            --border-color: #e2e8f0;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .topic-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        /* .workspace-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 0.7rem;
            font-weight: 500;
            margin-left: 8px;
            display: inline-block;
        } */

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
        }

        .tag-item {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
            color: #4a5568;
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .tag-item:hover {
            background: linear-gradient(135deg, #bee3f8 0%, #90cdf4 100%);
            color: #2b6cb0;
            border-color: #90cdf4;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-avatar-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .note-content {
            font-size: 1rem;
            line-height: 1.6;
            color: var(--text-primary);
        }

        .note-content p {
            margin-bottom: 1rem;
        }

        .attachment-item {
            transition: all 0.2s ease;
        }

        .attachment-item:hover {
            background-color: var(--bg-light);
        }

        /* SweetAlert Custom Styling */
        .swal2-popup-custom {
            border-radius: 16px !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .swal2-title-custom {
            color: var(--text-primary) !important;
            font-weight: 600 !important;
            font-size: 1.5rem !important;
        }

        .swal2-content-custom {
            color: var(--text-secondary) !important;
            font-size: 1rem !important;
        }

        .swal2-confirm-custom {
            background: linear-gradient(135deg, var(--danger-color) 0%, #c53030 100%) !important;
            border: none !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            padding: 12px 24px !important;
        }

        .swal2-cancel-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
            border: none !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            padding: 12px 24px !important;
            color: white !important;
        }
    </style>
@endsection
