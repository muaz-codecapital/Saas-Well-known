<div class="col text-end">
    <div class="btn-group" role="group" aria-label="View Types">
        <a href="{{ route('admin.product-planning.list', array_merge(request()->query(), ['view_type' => 'list'])) }}"
           type="button"
           class="btn {{ request()->view_type === 'list' || !request()->view_type ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-list me-2">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
            {{__('List')}}
        </a>

        <a href="{{ route('admin.product-planning.kanban', request()->query()) }}"
           type="button"
           class="btn {{ request()->routeIs('admin.product-planning.kanban') ? 'btn-gradient-primary text-white shadow-sm' : 'btn-outline-primary' }} rounded-pill px-4 py-2 me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-trello me-2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <rect x="7" y="7" width="3" height="9"></rect>
                <rect x="14" y="7" width="3" height="5"></rect>
            </svg>
            {{__('Kanban')}}
        </a>

    </div>

    <div class="btn-group ms-2">
        <button type="button" class="btn btn-gradient-success text-white dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-plus me-2"></i>{{__('Add Actions')}}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="#" onclick="showCreateModal()">
                    <i class="fas fa-plus me-2 text-primary"></i>{{__('Add Item')}}
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-box me-2 text-info"></i>{{__('Add Product')}}
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                    <i class="fas fa-building me-2 text-warning"></i>{{__('Add Department')}}
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addMilestoneModal">
                    <i class="fas fa-flag me-2 text-success"></i>{{__('Add Milestone')}}
                </a>
            </li>
        </ul>
    </div>

    <div class="btn-group ms-2">
        <button type="button" class="btn btn-outline-primary dropdown-toggle rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-filter me-2"></i>{{__('Filters')}}
        </button>
        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 350px;">
            <form method="GET" action="{{ route('admin.product-planning.list') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">{{__('Status')}}</label>
                        <select class="form-select" name="status">
                            <option value="">{{__('All Statuses')}}</option>
                            @foreach(config('product_planning.statuses') as $key => $status)
                                <option value="{{ $key }}" {{ request()->status === $key ? 'selected' : '' }}>
                                    {{ $status['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">{{__('Priority')}}</label>
                        <select class="form-select" name="priority">
                            <option value="">{{__('All Priorities')}}</option>
                            @foreach(config('product_planning.priorities') as $key => $priority)
                                <option value="{{ $key }}" {{ request()->priority === $key ? 'selected' : '' }}>
                                    {{ $priority['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">{{__('Product')}}</label>
                        <select class="form-select" name="product_id">
                            <option value="">{{__('All Products')}}</option>
                            @foreach($products ?? [] as $product)
                                <option value="{{ $product->id }}" {{ (request()->product_id == $product->id) ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">{{__('Department')}}</label>
                        <select class="form-select" name="department_id">
                            <option value="">{{__('All Departments')}}</option>
                            @foreach($departments ?? [] as $department)
                                <option value="{{ $department->id }}" {{ (request()->department_id == $department->id) ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">{{__('Assigned To')}}</label>
                        <select class="form-select" name="assigned_to">
                            <option value="">{{__('All Users')}}</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}" {{ (request()->assigned_to == $user->id) ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">{{__('Search')}}</label>
                        <input type="text" class="form-control" name="search" value="{{ request()->search }}" placeholder="{{__('Search items...')}}">
                    </div>
                </div>

                <div class="d-flex justify-content-between gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">{{__('Apply Filters')}}</button>
                    <a href="{{ route('admin.product-planning.list') }}" class="btn btn-outline-secondary btn-sm">{{__('Clear')}}</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        color: white !important;
    }

    .btn-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
        border: none !important;
        color: white !important;
    }

    .btn-gradient-primary:hover,
    .btn-gradient-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    /* Ensure proper button states */
    .btn-group .btn.btn-outline-primary {
        background: transparent !important;
        border: 2px solid #667eea !important;
        color: #667eea !important;
    }
    
    .btn-group .btn.btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border-color: transparent !important;
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    /* Override any conflicting styles */
    .btn-group .btn:not(.btn-gradient-primary):not(.btn-gradient-success) {
        background: transparent !important;
        border: 2px solid #667eea !important;
        color: #667eea !important;
    }
    
    .btn-group .btn:not(.btn-gradient-primary):not(.btn-gradient-success):hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border-color: transparent !important;
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">{{__('Add New Product')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="product_name" class="form-label">{{__('Product Name')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="product_name" name="name" required>
                                <div class="form-text">{{__('Enter a unique name for your product')}}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="product_version" class="form-label">{{__('Version')}}</label>
                                <input type="text" class="form-control" id="product_version" name="version" value="1.0.0">
                                <div class="form-text">{{__('Current version number')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="product_description" class="form-label">{{__('Description')}}</label>
                        <textarea class="form-control" id="product_description" name="description" rows="3" placeholder="{{__('Brief description of the product')}}"></textarea>
                        <div class="form-text">{{__('Optional description of the product purpose and goals')}}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary" id="addProductBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        {{__('Save Product')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">{{__('Add New Department')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addDepartmentForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">{{__('Department Name')}} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="department_name" name="name" required>
                        <div class="form-text">{{__('Enter the department name')}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="department_description" class="form-label">{{__('Description')}}</label>
                        <textarea class="form-control" id="department_description" name="description" rows="3" placeholder="{{__('Brief description of the department')}}"></textarea>
                        <div class="form-text">{{__('Optional description of the department responsibilities')}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="department_manager" class="form-label">{{__('Manager')}}</label>
                        <select class="form-select" id="department_manager" name="manager_id">
                            <option value="">{{__('Select Manager (Optional)')}}</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">{{__('Select the department manager or leave empty')}}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary" id="addDepartmentBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        {{__('Save Department')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Milestone Modal -->
<div class="modal fade" id="addMilestoneModal" tabindex="-1" aria-labelledby="addMilestoneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMilestoneModalLabel">{{__('Add New Milestone')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMilestoneForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="milestone_title" class="form-label">{{__('Milestone Title')}} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="milestone_title" name="title" required>
                        <div class="form-text">{{__('Enter a clear, descriptive milestone name')}}</div>
                    </div>
                    <div class="mb-3">
                        <label for="milestone_description" class="form-label">{{__('Description')}}</label>
                        <textarea class="form-control" id="milestone_description" name="description" rows="3" placeholder="{{__('Describe the milestone objectives and deliverables')}}"></textarea>
                        <div class="form-text">{{__('Optional detailed description of the milestone goals')}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="milestone_start_date" class="form-label">{{__('Start Date')}}</label>
                            <input type="date" class="form-control" id="milestone_start_date" name="start_date">
                            <div class="form-text">{{__('When the milestone work begins')}}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="milestone_due_date" class="form-label">{{__('Due Date')}}</label>
                            <input type="date" class="form-control" id="milestone_due_date" name="due_date">
                            <div class="form-text">{{__('Target completion date')}}</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="milestone_product" class="form-label">{{__('Related Product')}}</label>
                        <select class="form-select" id="milestone_product" name="product_id">
                            <option value="">{{__('Select Product (Optional)')}}</option>
                            @foreach($products ?? [] as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">{{__('Associate with a specific product or leave empty')}}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary" id="addMilestoneBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        {{__('Save Milestone')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Add Product Form Handler
    document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(this);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        // Disable button and show spinner
        const submitBtn = document.getElementById('addProductBtn');
        const spinner = submitBtn.querySelector('.spinner-border');
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');

        // Clear previous errors
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: '{{ route("admin.product-planning.store-product") }}',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{__("Success!")}}',
                        text: response.message || '{{__("Product created successfully!")}}',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#addProductModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Error!")}}',
                        text: response.message || '{{__("Something went wrong!")}}'
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = [];

                    Object.keys(errors).forEach(function(key) {
                        const field = $('#' + key.replace(/\./g, '_'));
                        field.addClass('is-invalid');

                        errors[key].forEach(function(error) {
                            field.after('<div class="invalid-feedback d-block">' + error + '</div>');
                            errorMessages.push(error);
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Validation Error!")}}',
                        html: errorMessages.join('<br>')
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Error!")}}',
                        text: '{{__("Something went wrong. Please try again.")}}'
                    });
                }
            },
            complete: function() {
                // Re-enable button and hide spinner
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            }
        });
    });

    // Add Department Form Handler
    document.getElementById('addDepartmentForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(this);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        // Disable button and show spinner
        const submitBtn = document.getElementById('addDepartmentBtn');
        const spinner = submitBtn.querySelector('.spinner-border');
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');

        // Clear previous errors
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: '{{ route("admin.product-planning.store-department") }}',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{__("Success!")}}',
                        text: response.message || '{{__("Department created successfully!")}}',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#addDepartmentModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Error!")}}',
                        text: response.message || '{{__("Something went wrong!")}}'
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = [];

                    Object.keys(errors).forEach(function(key) {
                        const field = $('#' + key.replace(/\./g, '_'));
                        field.addClass('is-invalid');

                        errors[key].forEach(function(error) {
                            field.after('<div class="invalid-feedback d-block">' + error + '</div>');
                            errorMessages.push(error);
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Validation Error!")}}',
                        html: errorMessages.join('<br>')
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Error!")}}',
                        text: '{{__("Something went wrong. Please try again.")}}'
                    });
                }
            },
            complete: function() {
                // Re-enable button and hide spinner
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            }
        });
    });

    // Add Milestone Form Handler
    document.getElementById('addMilestoneForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(this);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        // Disable button and show spinner
        const submitBtn = document.getElementById('addMilestoneBtn');
        const spinner = submitBtn.querySelector('.spinner-border');
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');

        // Clear previous errors
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: '{{ route("admin.product-planning.store-milestone") }}',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{__("Success!")}}',
                        text: response.message || '{{__("Milestone created successfully!")}}',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#addMilestoneModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Error!")}}',
                        text: response.message || '{{__("Something went wrong!")}}'
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = [];

                    Object.keys(errors).forEach(function(key) {
                        const field = $('#' + key.replace(/\./g, '_'));
                        field.addClass('is-invalid');

                        errors[key].forEach(function(error) {
                            field.after('<div class="invalid-feedback d-block">' + error + '</div>');
                            errorMessages.push(error);
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Validation Error!")}}',
                        html: errorMessages.join('<br>')
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__("Error!")}}',
                        text: '{{__("Something went wrong. Please try again.")}}'
                    });
                }
            },
            complete: function() {
                // Re-enable button and hide spinner
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            }
        });
    });

    // Real-time validation for required fields
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(function(field) {
        field.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
                let feedback = this.nextElementSibling;
                if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback d-block';
                    feedback.textContent = '{{__("This field is required")}}';
                    this.parentNode.insertBefore(feedback, this.nextSibling);
                }
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
            }
        });

        field.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                const feedback = this.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
            }
        });
    });
</script>
