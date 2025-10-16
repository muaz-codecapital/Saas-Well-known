<div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addGroupForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGroupModalLabel"><?php echo e(__('Add New WorkSpace')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="workspace_name"><?php echo e(__('Workspace Name')); ?></label>
                        <input type="text" class="form-control" id="workspace_name" name="workspace_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?php echo e(__('Save')); ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('addGroupForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let statusName = document.getElementById('workspace_name').value.trim();
        console.log(statusName);
        $.post("<?php echo e(route('tasks.addGroup')); ?>", {
            _token: "<?php echo e(csrf_token()); ?>",
            workspace_name: statusName,
        }).done(function(res) {
            if(res.success){
                let modalEl = document.getElementById('addGroupModal');
                let modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                location.reload();
            } else {
                alert(res.message || 'Error adding status');
            }
        });
    });
</script>
<?php /**PATH C:\laragon\www\well-known\resources\views/tasks/add-group.blade.php ENDPATH**/ ?>