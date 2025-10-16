<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('Add Task')); ?></h5>
            </div>

            <form method="post" id="form_main">
                <div class="modal-body">
                    <div id="sp_result_div"></div>
                    <!-- Hidden input for group -->
                    
                    <div class="">
                        <label for="input_name" class="required form-label"><?php echo e(__('Subject/Task')); ?></label>
                        <input type="text" id="input_name" name="subject" class="form-control form-control-solid" placeholder=""/>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-6">
                            <label class="required form-label"><?php echo e(__('Start Date')); ?></label>
                            <input type="text" placeholder="Pick Date" id="start_date" name="start_date"
                                   <?php if(!empty($task)): ?> value="<?php echo e($task->start_date); ?>" <?php endif; ?>
                                   class="form-control form-control-solid flatpickr-input"/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo e(__('End Date')); ?></label>
                            <input type="text" id="due_date" name="due_date"
                                   class="form-control form-control-solid"
                                   <?php if(!empty($task)): ?> value="<?php echo e($task->due_date); ?>" <?php endif; ?>
                                   placeholder="Pick Date"/>
                        </div>
                    </div>

                    
                    <div class="mb-1 mt-2">
                        <label for="contact" class="form-label"><?php echo e(__('Assign To')); ?></label>
                        <select class="form-select form-select-solid fw-bolder" id="contact" name="contact_id">
                            <option value="0"><?php echo e(__('None')); ?></option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usertask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($usertask->id); ?>"
                                        <?php if(!empty($task) && $task->contact_id === $usertask->id): ?> selected <?php endif; ?>>
                                    <?php echo e($usertask->first_name); ?> <?php echo e($usertask->last_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="mb-2">
                        <label for="group" class="form-label"><?php echo e(__('Group')); ?></label>
                        <select class="form-select form-select-solid fw-bolder" id="group" name="group">
                            <?php $__currentLoopData = config('groups.groups'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"
                                        <?php if(!empty($task) && $task->group === $key): ?> selected <?php endif; ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>


                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label for="description" class="form-label"><?php echo e(__('Description')); ?></label>
                                <textarea name="description" id="description"
                                          class="form-control form-control-solid"
                                          rows="7"><?php if(!empty($task)): ?><?php echo e($task->description); ?><?php endif; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="ms-3">
                    <?php echo csrf_field(); ?>
                    <button type="submit" id="btn_submit" class="btn btn-info"><?php echo e(__('Save')); ?></button>
                    <button type="button" class="btn bg-pink-light text-danger" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                </div>
                <input type="hidden" name="task_id" id="task_id" value="">
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\well-known\resources\views/tasks/add-new.blade.php ENDPATH**/ ?>