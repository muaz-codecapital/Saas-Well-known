@extends('layouts.primary')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-gradient-primary py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-white">
                                <i class="fas fa-sticky-note me-2"></i>
                                {{ $note ? __('Edit Note') : __('Create New Note') }}
                            </h4>
                            <div>
                                @if($note)
                                    <a href="/notes" class="btn btn-light btn-sm me-2">
                                        <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Notes') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                </div>

                    <div class="card-body">
                        <form id="noteForm" enctype="multipart/form-data">
                            @csrf
                            @if($note)
                                <input type="hidden" name="id" value="{{ $note->id }}">
            @endif

                            <!-- Error Messages -->
                            <div id="errorMessages" class="alert alert-danger d-none">
                                <ul class="list-unstyled mb-0"></ul>
                            </div>

                            <!-- Success Message -->
                            <div id="successMessage" class="alert alert-success d-none">
                                <i class="fas fa-check-circle me-2"></i>
                                <span></span>
                            </div>

                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-lg-8">
                                    <!-- Title -->
                                    <div class="mb-4">
                                        <label for="title" class="form-label fw-bold">
                                            {{ __('Title') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               name="title"
                                               id="title"
                                               class="form-control form-control-lg"
                                               value="{{ $note->title ?? old('title') ?? '' }}"
                                               placeholder="{{ __('Enter note title...') }}"
                                               required>
                                        <div class="form-text">{{ __('Choose a clear, descriptive title for your note') }}</div>
                                        <div class="invalid-feedback" id="title-error"></div>
                </div>

                                    <!-- Topic/Subject -->
                                    <div class="mb-4">
                                        <label for="topic" class="form-label fw-bold">
                                            {{ __('Topic/Subject') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               name="topic"
                                               id="topic"
                                               class="form-control"
                                               value="{{ $note->topic ?? old('topic') ?? '' }}"
                                               placeholder="{{ __('Enter topic or subject...') }}"
                                               required>
                                        <div class="invalid-feedback" id="topic-error"></div>
                </div>

                                    <!-- Tags -->
                                    <div class="mb-4">
                                        <label for="tags" class="form-label fw-bold">
                                            {{ __('Tags') }} <span class="text-danger">*</span>
                                        </label>
                                        <select name="tags[]" id="tags" class="form-select" multiple required>
                                            @if($note && $note->relationLoaded('noteTags') && $note->noteTags)
                                                @foreach($note->noteTags as $tag)
                                                    <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="form-text">{{ __('Select existing tags or create new ones') }}</div>
                                        <div class="invalid-feedback" id="tags-error"></div>
                                    </div>

                                    <!-- Notes Editor -->
                                    <div class="mb-4">
                                        <label for="notes" class="form-label fw-bold">
                                            {{ __('Notes Content') }} <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="notes"
                                                  id="notes"
                            class="form-control"
                                                  rows="10"
                                                  placeholder="{{ __('Write your notes here...') }}"
                                                  required>{!! $note->notes ?? old('notes') !!}</textarea>
                                        <div class="invalid-feedback" id="notes-error"></div>
                                    </div>

                                    <!-- Attachments Section -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">{{ __('File Attachments') }}</label>
                                        <div class="mb-3">
                                            <input type="file"
                                                   id="fileAttachments"
                                                   name="attachments[]"
                                                   multiple
                                                   class="form-control"
                                                   accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.gif,.xlsx,.xls,.ppt,.pptx">
                                            <div class="form-text">{{ __('Select files to attach (PDF, Word, images, spreadsheets)') }}</div>
                                        </div>

                                        <!-- File Preview Area -->
                                        <div id="filePreview" class="row"></div>

                                        <!-- Current Attachments (for editing) -->
                                        @if($note && $note->attachments)
                                            <div class="mt-3">
                                                <h6 class="fw-bold">{{ __('Current Attachments') }}</h6>
                                                <div class="row" id="currentAttachments">
                                                    @foreach($note->attachments_with_urls as $index => $attachment)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                                                                <div class="flex-grow-1">
                                                                    <i class="fas fa-file me-2"></i>
                                                                    {{ $attachment['name'] }}
                                                                    <small class="text-muted d-block">
                                                                        {{ $note->getFormattedFileSize($attachment['size']) }}
                                                                    </small>
                                                                </div>
                                                                <button type="button"
                                                                        class="btn btn-sm btn-outline-danger"
                                                                        onclick="removeCurrentAttachment({{ $index }})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                </div>

                                <!-- Right Column -->
                                <div class="col-lg-4">
                                    <!-- Cover Photo -->
                                    <div class="mb-4">
                                        <label for="cover_photo" class="form-label fw-bold">{{ __('Cover Photo') }}</label>
                                        <div class="text-center">
                                            <div id="coverPhotoPreview" class="mb-3">
                                                @if($note && $note->cover_photo)
                                                    <img src="{{ $note->cover_photo_url }}"
                                                         alt="Cover Photo"
                                                         class="img-fluid rounded border"
                                                         style="max-height: 200px;">
                                                @else
                                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                                         style="height: 200px;">
                                                        <i class="fas fa-image fa-3x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file"
                                                   name="cover_photo"
                                                   id="cover_photo"
                                                   class="form-control"
                                                   accept="image/*">
                                            <div class="form-text">{{ __('Upload a cover image for your note (optional)') }}</div>
                    </div>
                </div>

                                    <!-- Workspace Selection -->
                                    <!-- <div class="mb-4">
                                        <label for="workspace" class="form-label fw-bold">{{ __('Workspace') }}</label>
                                        <select name="workspace" id="workspace" class="form-select">
                                            <option value="">{{ __('Select Workspace') }}</option>
                        @foreach(config('groups.groups') as $group)
                                                <option value="{{ $group }}"
                                                        {{ ($note && $note->workspace === $group) || old('workspace') === $group ? 'selected' : '' }}>
                                                    {{ ucfirst($group) }}
                                                </option>
                        @endforeach
                    </select>
                                        <div class="form-text">{{ __('Organize notes by workspace category') }}</div>
                                    </div> -->

                                    <!-- Reference File -->
                                    <div class="mb-4">
                                        <label for="reference_file" class="form-label fw-bold">{{ __('Reference File') }}</label>
                                        <input type="file"
                                               name="reference_file"
                                               id="reference_file"
                                               class="form-control"
                                               accept=".pdf,.doc,.docx,.txt,.xlsx,.xls">
                                        @if($note && $note->reference_file)
                                            <div class="mt-2">
                                                <a href="{{ $note->reference_file_url }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download me-1"></i>{{ __('Current Reference File') }}
                                                </a>
                                            </div>
                                        @endif
                                        <div class="form-text">{{ __('Upload a reference document (PDF, Word, Excel)') }}</div>
                </div>

                                    <!-- Save Button -->
                                    <div class="d-grid">
                                        <button type="submit"
                                                id="saveBtn"
                                                class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>
                                            <span>{{ __('Save Note') }}</span>
                                        </button>
                                    </div>
                                </div>
                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize TinyMCE
            tinymce.init({
                selector: '#notes',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'paste', 'help', 'wordcount',
                    'emoticons', 'template', 'codesample', 'hr', 'pagebreak', 'nonbreaking'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic underline strikethrough | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | link image media | forecolor backcolor | ' +
                    'emoticons | code codesample | preview fullscreen',
                menubar: 'edit view insert format tools table help',
                min_height: 400,
                max_height: 600,
                resize: true,
                convert_newlines_to_brs: false,
                statusbar: true,
                relative_urls: false,
                remove_script_host: false,
                language: 'en',
                branding: false,
                image_advtab: true,
                link_context_toolbar: true,
                link_title: false,
                automatic_uploads: false,
                file_picker_types: 'file image media',
                paste_data_images: true,
                paste_as_text: false,
                paste_remove_styles: false,
                paste_remove_styles_if_webkit: false,
                content_css: [
                    '{{ asset("css/app.css") }}',
                    '//fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap'
                ],
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save();
                    });
                }
            });

            // Initialize Select2 for tags input
            $('#tags').select2({
                placeholder: 'Select or create tags...',
                allowClear: true,
                multiple: true,
                tags: true,
                createTag: function (params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: 'new:' + term,
                        text: term + ' (new)',
                        newTag: true
                    };
                },
                ajax: {
                    url: '{{ route("tags.api") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data.map(function(tag) {
                                return {
                                    id: tag.id,
                                    text: tag.name,
                                    color: tag.color
                                };
                            })
                        };
                    },
                    cache: true
                },
                templateResult: function(tag) {
                    if (tag.loading) {
                        return tag.text;
                    }
                    var $result = $(
                        '<span>' + tag.text + '</span>'
                    );
                    if (tag.color) {
                        $result.prepend('<span class="tag-color-indicator" style="background-color: ' + tag.color + '"></span>');
                    }
                    return $result;
                },
                templateSelection: function(tag) {
                    if (tag.newTag) {
                        return tag.text;
                    }
                    return tag.text;
                }
            });

            // Handle new tag creation
            $('#tags').on('select2:select', function (e) {
                var data = e.params.data;
                if (data.newTag) {
                    var tagName = data.id.replace('new:', '');
                    createNewTag(tagName);
                }
            });


            // Form submission
            $('#noteForm').on('submit', function(e) {
                e.preventDefault();
                
                // Basic frontend validation
                if (!validateForm()) {
                    return;
                }
                
                saveNote();
            });

            // Real-time validation on input change
            $('#title, #topic, #tags, #notes').on('blur', function() {
                validateField($(this));
            });
        });

        // Setup file upload functionality
        function setupFileUploads() {
            const fileInput = $('#fileAttachments');
            const filePreview = $('#filePreview');

            // Ensure file input is properly configured
            if (fileInput.length === 0) {
                console.error('File input not found!');
                return;
            }

            console.log('Setting up file uploads...');

            // Simple file input change handler
            fileInput.on('change', function() {
                console.log('File input changed, files:', this.files);
                handleFiles(this.files);
            });

            function handleFiles(files) {
                [...files].forEach(previewFile);
            }

            function previewFile(file) {
                if (!validateFile(file)) return;

                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function() {
                    const fileCard = createFileCard(file, reader.result);
                    filePreview.append(fileCard);
                };
            }

            function validateFile(file) {
                const maxSize = 10 * 1024 * 1024; // 10MB
                const allowedTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain',
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/gif',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                ];

                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File too large',
                        text: `${file.name} is larger than 10MB`
                    });
                    return false;
                }

                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid file type',
                        text: `${file.name} is not a supported file type`
                    });
                    return false;
                }

                return true;
            }

            function createFileCard(file, previewUrl) {
                const fileType = getFileType(file.type);
                const fileSize = formatFileSize(file.size);

                return $(`
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 file-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas ${getFileIcon(fileType)} fa-2x me-3 text-primary"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-0 text-truncate">${file.name}</h6>
                                        <small class="text-muted">${fileType.toUpperCase()} • ${fileSize}</small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeFile(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                ${file.type.startsWith('image/') ? `<img src="${previewUrl}" class="img-fluid rounded mb-2" style="max-height: 100px;">` : ''}
                            </div>
                        </div>
                    </div>
                `);
            }

            function removeFile(button) {
                $(button).closest('.col-md-6').remove();
            }

            window.removeFile = removeFile;
        }

        // Cover photo preview
        $('#cover_photo').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#coverPhotoPreview').html(`
                        <img src="${e.target.result}" alt="Cover Photo" class="img-fluid rounded border" style="max-height: 200px;">
                    `);
                };
                reader.readAsDataURL(file);
            }
        });

        // Save note function with AJAX
        function saveNote() {
            const formData = new FormData($('#noteForm')[0]);
            const saveBtn = $('#saveBtn');
            const btnText = saveBtn.find('span');
            const btnIcon = saveBtn.find('i');

            // Clear previous validation errors
            clearValidationErrors();

            // Disable button and show loading state
            saveBtn.prop('disabled', true);
            btnIcon.removeClass('fa-save').addClass('fa-spinner fa-spin');
            btnText.text('{{ __("Saving...") }}');

            // Hide previous messages
            $('#errorMessages, #successMessage').addClass('d-none');

            // Get TinyMCE content
            if (tinymce.get('notes')) {
                formData.set('notes', tinymce.get('notes').getContent());
            }

            $.ajax({
                url: '{{ route("notes.store") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Show success message
                    $('#successMessage span').text(response.message || '{{ __("Note saved successfully!") }}');
                    $('#successMessage').removeClass('d-none');

                    // Redirect after delay
                    setTimeout(function() {
                        window.location.href = '/notes';
                    }, 1500);
                },
                error: function(xhr) {
                    // Show validation errors
                    const errors = xhr.responseJSON?.errors;
                    
                    if (errors) {
                        // Show field-specific errors
                        showValidationErrors(errors);
                    } else {
                        // Show general error message
                        const errorContainer = $('#errorMessages ul');
                        errorContainer.empty();
                        errorContainer.append('<li>{{ __("An error occurred while saving the note.") }}</li>');
                        $('#errorMessages').removeClass('d-none');
                    }

                    // Scroll to first error
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                },
                complete: function() {
                    // Re-enable button
                    saveBtn.prop('disabled', false);
                    btnIcon.removeClass('fa-spinner fa-spin').addClass('fa-save');
                    btnText.text('{{ __("Save Note") }}');
                }
            });
        }

        // Clear validation errors
        function clearValidationErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('').hide();
        }

        // Show validation errors
        function showValidationErrors(errors) {
            Object.keys(errors).forEach(field => {
                const fieldElement = $(`[name="${field}"]`);
                const errorElement = $(`#${field}-error`);
                
                if (fieldElement.length && errorElement.length) {
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errors[field][0]).show();
                }
            });
        }

        // Frontend form validation
        function validateForm() {
            let isValid = true;
            
            // Clear previous errors
            clearValidationErrors();
            
            // Validate required fields
            const requiredFields = [
                { name: 'title', label: 'Title' },
                { name: 'topic', label: 'Topic/Subject' },
                { name: 'notes', label: 'Notes Content' }
            ];
            
            requiredFields.forEach(field => {
                const fieldElement = $(`[name="${field.name}"]`);
                let value = fieldElement.val();
                
                // For TinyMCE, get content from editor
                if (field.name === 'notes' && tinymce.get('notes')) {
                    value = tinymce.get('notes').getContent();
                }
                
                if (!value || value.trim() === '') {
                    fieldElement.addClass('is-invalid');
                    $(`#${field.name}-error`).text(`${field.label} is required.`).show();
                    isValid = false;
                }
            });

            // Special validation for tags
            const selectedTags = $('#tags').val();
            if (!selectedTags || selectedTags.length === 0) {
                $('#tags').addClass('is-invalid');
                $('#tags-error').text('At least one tag is required.').show();
                isValid = false;
            }
            
            return isValid;
        }

        // Validate individual field
        function validateField(fieldElement) {
            const fieldName = fieldElement.attr('name');
            let value = fieldElement.val();
            
            // For TinyMCE, get content from editor
            if (fieldName === 'notes' && tinymce.get('notes')) {
                value = tinymce.get('notes').getContent();
            }
            
            if (!value || value.trim() === '') {
                fieldElement.addClass('is-invalid');
                $(`#${fieldName}-error`).text(`${getFieldLabel(fieldName)} is required.`).show();
                return false;
            } else {
                fieldElement.removeClass('is-invalid');
                $(`#${fieldName}-error`).hide();
                return true;
            }
        }

        // Get field label
        function getFieldLabel(fieldName) {
            const labels = {
                'title': 'Title',
                'topic': 'Topic/Subject',
                'tags': 'Tags',
                'notes': 'Notes Content'
            };
            return labels[fieldName] || fieldName;
        }

        // Remove current attachment (for editing)
        function removeCurrentAttachment(index) {
            Swal.fire({
                title: 'Remove attachment?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#667eea',
                confirmButtonText: 'Yes, remove it',
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
                    // Here you would make an AJAX call to remove the attachment from server
                    // For now, just remove from UI
                    $(`#currentAttachments .col-md-6`).eq(index).remove();

                    Swal.fire(
                        'Removed!',
                        'The attachment has been removed.',
                        'success'
                    );
                }
            });
        }

        window.removeCurrentAttachment = removeCurrentAttachment;

        // Create new tag function
        function createNewTag(tagName) {
            $.ajax({
                url: '{{ route("tags.create.api") }}',
                method: 'POST',
                data: {
                    name: tagName,
                    color: '#667eea',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Add the new tag to Select2
                        var newOption = new Option(response.data.name, response.data.id, true, true);
                        $('#tags').append(newOption).trigger('change');
                        
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Tag created successfully!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors && errors.name) {
                        Swal.fire({
                            title: 'Error!',
                            text: errors.name[0],
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to create tag. Please try again.',
                            icon: 'error'
                        });
                    }
                }
            });
        }

        // Helper functions
        function getFileType(mimeType) {
            if (mimeType.startsWith('image/')) return 'image';
            if (mimeType.includes('pdf')) return 'pdf';
            if (mimeType.includes('word') || mimeType.includes('document')) return 'document';
            if (mimeType.includes('excel') || mimeType.includes('spreadsheet')) return 'spreadsheet';
            if (mimeType.includes('powerpoint') || mimeType.includes('presentation')) return 'presentation';
            return 'file';
        }

        function getFileIcon(fileType) {
            const icons = {
                'image': 'fa-image',
                'pdf': 'fa-file-pdf',
                'document': 'fa-file-word',
                'spreadsheet': 'fa-file-excel',
                'presentation': 'fa-file-powerpoint',
                'file': 'fa-file'
            };
            return icons[fileType] || 'fa-file';
        }

        function formatFileSize(bytes) {
            const units = ['B', 'KB', 'MB', 'GB'];
            let size = bytes;
            let unitIndex = 0;

            while (size >= 1024 && unitIndex < units.length - 1) {
                size /= 1024;
                unitIndex++;
            }

            return `${size.toFixed(1)} ${units[unitIndex]}`;
        }
    </script>

    <style>

        .file-card {
            transition: transform 0.2s ease;
        }

        .file-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

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

        /* Form Elements with Consistent Colors */
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-color) 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            min-height: 48px;
            padding: 4px;
        }

        .select2-container--default .select2-selection--multiple:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 16px;
            color: white;
            padding: 4px 12px;
            margin: 2px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 6px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ffcccc;
        }

        .tag-color-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
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

        .is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
    </style>
@endsection



