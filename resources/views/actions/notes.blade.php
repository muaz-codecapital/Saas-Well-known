@extends('layouts.primary')
@section('content')
<style>
    .input-group .form-control:not(:first-child) {
        border-left: 0;
        padding-left: 10px !important;
    }
</style>

    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary shadow-lg">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="text-white mb-2">
                                    <i class="fas fa-sticky-note me-2"></i>{{ __('My Notes') }}
                                </h2>
                                <p class="text-white-50 mb-0">{{ __('Organize your thoughts, ideas, and important information') }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <a href="{{ route('tags.index') }}" class="btn btn-outline-light btn-lg me-2">
                                    <i class="fas fa-tags me-2"></i>{{ __('Manage Tags') }}
                                </a>
                                <a href="/add-note" class="btn btn-light btn-lg">
                                    <i class="fas fa-plus me-2"></i>{{ __('Create New Note') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>

        <!-- Filters and Search -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Search -->
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           id="searchInput"
                                           class="form-control"
                                           placeholder="{{ __('Search notes...') }}">
                                </div>
                            </div>

                            <!-- Workspace Filter -->
                            <!-- <div class="col-md-3">
                                <select id="workspaceFilter" class="form-select">
                                    <option value="">{{ __('All Workspaces') }}</option>
                                    @foreach(config('groups.groups') as $group)
                                        <option value="{{ $group }}">{{ ucfirst($group) }}</option>
                                    @endforeach
                                </select>
                            </div> -->

                            <!-- Tag Filter -->
                            <div class="col-md-3">
                                <select id="tagFilter" class="form-select">
                                    <option value="">{{ __('All Tags') }}</option>
                                </select>
                            </div>

                            <!-- Clear Filters -->
                            <div class="col-md-2">
                                <button type="button" id="clearFilters" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times me-1"></i>{{ __('Clear') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Grid -->
        <div class="row g-4" id="notesContainer">
            @foreach($notes as $note)
                <div class="col-lg-4 col-md-6 col-12 note-card" data-note-id="{{ $note->id }}">
                    <div class="card h-100 border-0 shadow-sm note-card-item">
                        <!-- Cover Image Section -->
                        @if(!empty($note->cover_photo))
                            <div class="position-relative">
                                <img src="{{ asset('public/uploads/' . $note->cover_photo) }}"
                                     class="card-img-top cover-image"
                                     alt="Cover Photo">
                                @if($note->attachments && count($note->attachments) > 0)
                                    <span class="attachment-badge">
                                        <i class="fas fa-paperclip me-1"></i>{{ count($note->attachments) }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column p-4">
                            <!-- Header Section -->
                            <div class="mb-3">
                                <!-- Topic Badge -->
                                <div class="mb-2">
                                    <span class="topic-badge">{{ $note->topic }}</span>
                                    <!-- @if($note->workspace)
                                        <span class="workspace-badge">{{ ucfirst($note->workspace) }}</span>
                                    @endif -->
                                </div>

                                <!-- Title -->
                                <h5 class="card-title mb-2">{{ $note->title }}</h5>

                                <!-- Content Preview -->
                                <p class="card-text content-preview">
                                    {!! Str::limit(strip_tags($note->notes), 120) !!}
                                </p>
                            </div>

                            <!-- Tags Section -->
                            @php
                                $cleanTags = $note->clean_tags ?? [];
                            @endphp
                            @if(!empty($cleanTags) && count($cleanTags) > 0)
                                <div class="mb-3">
                                    <div class="tags-container">
                                        @php
                                            $displayTags = array_slice($cleanTags, 0, 3);
                                        @endphp
                                        @foreach($displayTags as $tag)
                                            <span class="tag-item">{{ ucfirst(strtolower($tag)) }}</span>
                                        @endforeach
                                        @if(count($cleanTags) > 3)
                                            <span class="tag-more">+{{ count($cleanTags) - 3 }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Footer Section -->
                            <div class="mt-auto">
                                <!-- Author and Date -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="author-info">
                                        <i class="fas fa-user-circle me-2 text-muted"></i>
                                        <span class="author-name">{{ $note->user->first_name ?? 'Unknown' }}</span>
                                        <span class="separator mx-2">•</span>
                                        <span class="date-info">{{ \Carbon\Carbon::parse($note->created_at)->format('M j, Y') }}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <a href="/view-note?id={{ $note->id }}"
                                       class="btn btn-action btn-view"
                                       title="{{ __('View Note') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/add-note?id={{ $note->id }}"
                                       class="btn btn-action btn-edit"
                                       title="{{ __('Edit Note') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-action btn-delete"
                                            onclick="deleteNote({{ $note->id }})"
                                            title="{{ __('Delete Note') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="row d-none">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-sticky-note fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">{{ __('No notes found') }}</h4>
                        <p class="text-muted mb-4">{{ __('Start creating your first note to get organized!') }}</p>
                        <a href="/add-note" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>{{ __('Create Your First Note') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="row d-none">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">{{ __('Loading...') }}</span>
                        </div>
                        <p class="text-muted mt-3">{{ __('Loading notes...') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize search and filtering
            setupSearchAndFilters();

            // Check if no notes exist
            checkEmptyState();
        });

        function setupSearchAndFilters() {
            let searchTimeout;

            // Search functionality
            $('#searchInput').on('input', function() {
                const searchTerm = $(this).val().trim();
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    filterNotes();
                }, 300);
            });

            // Workspace filter
            // $('#workspaceFilter').on('change', function() {
            //     filterNotes();
            // });

            // Tag filter
            $('#tagFilter').on('change', function() {
                filterNotes();
            });

            // Clear filters
            $('#clearFilters').on('click', function() {
                $('#searchInput').val('');
                // $('#workspaceFilter').val('');
                $('#tagFilter').val('');
                filterNotes();
            });

            // Populate available tags
            populateAvailableTags();
        }

        function populateAvailableTags() {
            // Fetch tags from the backend
            $.ajax({
                url: '{{ route("tags.api") }}',
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success && response.data) {
                        const tagFilter = $('#tagFilter');
                        
                        // Clear existing options except "All Tags"
                        tagFilter.find('option:not(:first)').remove();
                        
                        // Add tags from database
                        response.data.forEach(tag => {
                            tagFilter.append(`<option value="${tag.name}">${tag.name.charAt(0).toUpperCase() + tag.name.slice(1)}</option>`);
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Failed to load tags:', xhr);
                    // Fallback to hardcoded tags if API fails
                    const commonTags = ['idea', 'important', 'draft', 'final', 'research', 'planning'];
                    const tagFilter = $('#tagFilter');
                    tagFilter.find('option:not(:first)').remove();
                    commonTags.forEach(tag => {
                        tagFilter.append(`<option value="${tag}">${tag.charAt(0).toUpperCase() + tag.slice(1)}</option>`);
                    });
                }
            });
        }

        function filterNotes() {
            const searchTerm = $('#searchInput').val().trim().toLowerCase();
            // const workspaceFilter = $('#workspaceFilter').val();
            const tagFilter = $('#tagFilter').val();

            let visibleCount = 0;

            $('.note-card').each(function() {
                const card = $(this);
                const title = card.find('.card-title').text().toLowerCase();
                const content = card.find('.card-text').text().toLowerCase();
                const topic = card.find('.badge').first().text().toLowerCase();
                // const workspace = card.find('.badge.bg-info').text().toLowerCase();

                let shouldShow = true;

                // Search filter
                if (searchTerm && !title.includes(searchTerm) &&
                    !content.includes(searchTerm) && !topic.includes(searchTerm)) {
                    shouldShow = false;
                }

                // Workspace filter
                // if (workspaceFilter && workspace !== workspaceFilter.toLowerCase()) {
                //     shouldShow = false;
                // }

                // Tag filter - check if the note has the selected tag
                if (tagFilter) {
                    let hasTag = false;
                    card.find('.tag-item').each(function() {
                        const tagText = $(this).text().toLowerCase();
                        if (tagText === tagFilter.toLowerCase()) {
                            hasTag = true;
                            return false; // Break the loop
                        }
                    });
                    if (!hasTag) {
                        shouldShow = false;
                    }
                }

                if (shouldShow) {
                    card.show();
                    visibleCount++;
                } else {
                    card.hide();
                }
            });

            checkEmptyState(visibleCount);
        }

        function checkEmptyState(visibleCount = null) {
            const notesContainer = $('#notesContainer');
            const emptyState = $('#emptyState');

            if (visibleCount === null) {
                visibleCount = $('.note-card:visible').length;
            }

            if (visibleCount === 0) {
                notesContainer.hide();
                emptyState.removeClass('d-none');
            } else {
                notesContainer.show();
                emptyState.addClass('d-none');
            }
        }

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
                    // Show loading
                    Swal.fire({
                        title: '{{ __("Deleting...") }}',
                        text: '{{ __("Please wait while we delete your note.") }}',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Make AJAX request to delete
                    $.ajax({
                        url: `/notes/${noteId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            // Remove the note card from UI
                            $(`.note-card[data-note-id="${noteId}"]`).fadeOut(300, function() {
                                $(this).remove();
                                checkEmptyState();
                            });

                            Swal.fire(
                                'Deleted!',
                                'Your note has been deleted.',
                                'success'
                            );
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete the note. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        window.deleteNote = deleteNote;
        window.populateAvailableTags = populateAvailableTags;
    </script>

    <style>
        /* Card Styling */
        .note-card-item {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
        }

        .note-card-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Cover Image */
        .cover-image {
            height: 200px;
            object-fit: cover;
            border-radius: 0;
        }

        /* Attachment Badge */
        .attachment-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 123, 255, 0.9);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        /* Topic and Workspace Badges */
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
            margin-bottom: 8px;
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

        /* Card Title */
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        /* Content Preview */
        .content-preview {
            color: #718096;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Tags Container */
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

        .tag-more {
            background: #f7fafc;
            color: #a0aec0;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid #e2e8f0;
        }

        /* Author Info */
        .author-info {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #718096;
        }

        .author-name {
            font-weight: 500;
            color: #4a5568;
        }

        .separator {
            color: #cbd5e0;
        }

        .date-info {
            color: #a0aec0;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-view {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-edit {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #ed64a6 0%, #f56565 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
            color: #e53e3e;
            border: 1px solid #fed7d7;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #fc8181 0%, #f56565 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(229, 62, 62, 0.4);
        }

        /* Header Gradient */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

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

        /* Responsive Design */
        @media (max-width: 768px) {
            .note-card-item {
                margin-bottom: 20px;
            }
            
            .action-buttons {
                justify-content: center;
                margin-top: 12px;
            }
            
            .author-info {
                justify-content: center;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 20px !important;
            }
            
            .card-title {
                font-size: 1.1rem;
            }
            
            .btn-action {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }
        }

        /* Animation for loading */
        .note-card-item {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Empty state styling */
        .empty-state-icon {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
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
