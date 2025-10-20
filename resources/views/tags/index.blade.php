@extends('layouts.primary')
@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary shadow-lg">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="text-white mb-2">
                                    <i class="fas fa-tags me-2"></i>{{ __('Manage Tags') }}
                                </h2>
                                <p class="text-white-50 mb-0">{{ __('Organize your notes with custom tags') }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#createTagModal">
                                    <i class="fas fa-plus me-2"></i>{{ __('Create New Tag') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tags Grid -->
        <div class="row g-4" id="tagsContainer">
            @forelse($tags as $tag)
                <div class="col-lg-3 col-md-4 col-6 tag-card" data-tag-id="{{ $tag->id }}">
                    <div class="card h-100 border-0 shadow-sm tag-card-item">
                        <div class="card-body p-4 text-center">
                            <!-- Tag Color -->
                            <div class="tag-color-preview mb-3" style="background-color: {{ $tag->color }};">
                                <i class="fas fa-tag text-white"></i>
                            </div>

                            <!-- Tag Name -->
                            <h5 class="card-title mb-2">{{ $tag->name }}</h5>

                            <!-- Description -->
                            @if($tag->description)
                                <p class="card-text text-muted small">{{ Str::limit($tag->description, 80) }}</p>
                            @endif

                            <!-- Usage Count -->
                            <div class="mb-3">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-sticky-note me-1"></i>
                                    {{ $tag->usage_count }} {{ __('notes') }}
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="editTag({{ $tag->id }})" title="{{ __('Edit Tag') }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteTag({{ $tag->id }})" title="{{ __('Delete Tag') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-tags fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted">{{ __('No tags found') }}</h4>
                            <p class="text-muted mb-4">{{ __('Create your first tag to organize your notes!') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTagModal">
                                <i class="fas fa-plus me-2"></i>{{ __('Create Your First Tag') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($tags->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    {{ $tags->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Create Tag Modal -->
    <div class="modal fade" id="createTagModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>{{ __('Create New Tag') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="createTagForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tagName" class="form-label fw-bold">{{ __('Tag Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tagName" name="name" required>
                            <div class="invalid-feedback" id="tagName-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="tagColor" class="form-label fw-bold">{{ __('Tag Color') }}</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" id="tagColor" name="color" value="#667eea">
                                <span class="input-group-text">{{ __('Choose color') }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tagDescription" class="form-label fw-bold">{{ __('Description') }}</label>
                            <textarea class="form-control" id="tagDescription" name="description" rows="3" placeholder="{{ __('Optional description for this tag') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="createTagBtn">
                            <i class="fas fa-save me-2"></i>{{ __('Create Tag') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tag Modal -->
    <div class="modal fade" id="editTagModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>{{ __('Edit Tag') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editTagForm">
                    <input type="hidden" id="editTagId" name="tag_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editTagName" class="form-label fw-bold">{{ __('Tag Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editTagName" name="name" required>
                            <div class="invalid-feedback" id="editTagName-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="editTagColor" class="form-label fw-bold">{{ __('Tag Color') }}</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" id="editTagColor" name="color">
                                <span class="input-group-text">{{ __('Choose color') }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editTagDescription" class="form-label fw-bold">{{ __('Description') }}</label>
                            <textarea class="form-control" id="editTagDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="editTagBtn">
                            <i class="fas fa-save me-2"></i>{{ __('Update Tag') }}
                        </button>
                    </div>
                </form>
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
            // Create tag form submission
            $('#createTagForm').on('submit', function(e) {
                e.preventDefault();
                createTag();
            });

            // Edit tag form submission
            $('#editTagForm').on('submit', function(e) {
                e.preventDefault();
                updateTag();
            });
        });

        // Create new tag
        function createTag() {
            const formData = new FormData($('#createTagForm')[0]);
            const submitBtn = $('#createTagBtn');
            const btnText = submitBtn.find('span');
            const btnIcon = submitBtn.find('i');

            // Clear previous validation errors
            clearValidationErrors();

            // Disable button and show loading state
            submitBtn.prop('disabled', true);
            btnIcon.removeClass('fa-save').addClass('fa-spinner fa-spin');
            btnText.text('{{ __("Creating...") }}');

            $.ajax({
                url: '{{ route("tags.store") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#createTagModal').modal('hide');
                    $('#createTagForm')[0].reset();
                    
                    Swal.fire({
                        title: 'Success!',
                        text: 'Tag created successfully!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Reload the page to show new tag
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors;
                    
                    if (errors) {
                        showValidationErrors(errors);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to create tag. Please try again.',
                            icon: 'error'
                        });
                    }
                },
                complete: function() {
                    // Re-enable button
                    submitBtn.prop('disabled', false);
                    btnIcon.removeClass('fa-spinner fa-spin').addClass('fa-save');
                    btnText.text('{{ __("Create Tag") }}');
                }
            });
        }

        // Edit tag
        function editTag(tagId) {
            $.ajax({
                url: `/tags/${tagId}`,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    $('#editTagId').val(response.data.id);
                    $('#editTagName').val(response.data.name);
                    $('#editTagColor').val(response.data.color);
                    $('#editTagDescription').val(response.data.description);
                    $('#editTagModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to load tag details.',
                        icon: 'error'
                    });
                }
            });
        }

        // Update tag
        function updateTag() {
            const tagId = $('#editTagId').val();
            const formData = new FormData($('#editTagForm')[0]);
            const submitBtn = $('#editTagBtn');
            const btnText = submitBtn.find('span');
            const btnIcon = submitBtn.find('i');

            // Clear previous validation errors
            clearValidationErrors();

            // Disable button and show loading state
            submitBtn.prop('disabled', true);
            btnIcon.removeClass('fa-save').addClass('fa-spinner fa-spin');
            btnText.text('{{ __("Updating...") }}');

            $.ajax({
                url: `/tags/${tagId}`,
                method: 'PUT',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#editTagModal').modal('hide');
                    
                    Swal.fire({
                        title: 'Success!',
                        text: 'Tag updated successfully!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Reload the page to show updated tag
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors;
                    
                    if (errors) {
                        showValidationErrors(errors, 'edit');
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to update tag. Please try again.',
                            icon: 'error'
                        });
                    }
                },
                complete: function() {
                    // Re-enable button
                    submitBtn.prop('disabled', false);
                    btnIcon.removeClass('fa-spinner fa-spin').addClass('fa-save');
                    btnText.text('{{ __("Update Tag") }}');
                }
            });
        }

        // Delete tag
        function deleteTag(tagId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to recover this tag!",
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
                    $.ajax({
                        url: `/tags/${tagId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            $(`.tag-card[data-tag-id="${tagId}"]`).fadeOut(300, function() {
                                $(this).remove();
                            });

                            Swal.fire(
                                'Deleted!',
                                'Your tag has been deleted.',
                                'success'
                            );
                        },
                        error: function(xhr) {
                            const error = xhr.responseJSON?.message || 'Failed to delete tag. Please try again.';
                            Swal.fire(
                                'Error!',
                                error,
                                'error'
                            );
                        }
                    });
                }
            });
        }

        // Clear validation errors
        function clearValidationErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('').hide();
        }

        // Show validation errors
        function showValidationErrors(errors, prefix = '') {
            Object.keys(errors).forEach(field => {
                const fieldElement = $(`#${prefix}${field}`);
                const errorElement = $(`#${prefix}${field}-error`);
                
                if (fieldElement.length && errorElement.length) {
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errors[field][0]).show();
                }
            });
        }

        window.editTag = editTag;
        window.deleteTag = deleteTag;
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

        .tag-card-item {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
        }

        .tag-card-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .tag-color-preview {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 1.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
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
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .btn-outline-danger:hover {
            background: var(--danger-color);
            border-color: var(--danger-color);
            color: white;
            transform: translateY(-1px);
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

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
    </style>
@endsection
