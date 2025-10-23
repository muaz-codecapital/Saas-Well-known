<div class="modal fade" id="addStatusModal" tabindex="-1" aria-labelledby="addStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addStatusForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStatusModalLabel">{{__('Add New Status')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="status_name">{{__('Status Name')}}</label>
                        <input type="text" class="form-control" id="status_name" name="status_name" required>
                    </div>
                    <div class="form-group">
                        <label for="status_class">{{__('Status Class')}}</label>
                        <select class="form-control" id="status_class" name="status_class" required>
                            <option value="btn-secondary" style="background-color:#8392ab; color:white;">Secondary</option>
                            <option value="btn-info" style="background-color:#17c1e8; color:white;">Info</option>
                            <option value="btn-primary" style="background-color:#667eea; color:white;">Primary</option>
                            <option value="btn-warning" style="background-color:#fbcf33; color:black;">Warning</option>
                            <option value="btn-success" style="background-color:#11998e; color:white;">Success</option>
                            <option value="btn-danger" style="background-color:#ea0606; color:white;">Danger</option>
                            <option value="btn-dark" style="background-color:#344767; color:white;">Dark</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">{{__('Save')}}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const statusClassSelect = document.getElementById('status_class');

    // Apply initial color preview
    statusClassSelect.style.backgroundColor = statusClassSelect.selectedOptions[0].style.backgroundColor;
    statusClassSelect.style.color = statusClassSelect.selectedOptions[0].style.color;

    // Change background on selection
    statusClassSelect.addEventListener('change', function() {
        const selectedOption = statusClassSelect.selectedOptions[0];
        statusClassSelect.style.backgroundColor = selectedOption.style.backgroundColor;
        statusClassSelect.style.color = selectedOption.style.color;
    });

    document.getElementById('addStatusForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let statusName = document.getElementById('status_name').value.trim();
        let statusClass = document.getElementById('status_class').value;

        if (!statusName || !statusClass) return;

        $.post("{{ route('tasks.addStatus') }}", {
            _token: "{{ csrf_token() }}",
            status_name: statusName,
            status_class: statusClass
        }).done(function(res) {
            if(res.success){
                let modalEl = document.getElementById('addStatusModal');
                let modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                location.reload(); // or dynamically add the board
            } else {
                alert(res.message || 'Error adding status');
            }
        });
    });
</script>
