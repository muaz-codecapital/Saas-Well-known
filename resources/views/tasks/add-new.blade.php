<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Add Task')}}</h5>
            </div>

            <form method="post" id="form_main">
                <div class="modal-body">
                    <div id="sp_result_div"></div>
                    <!-- Hidden input for group -->
                    {{-- Subject --}}
                    <div class="">
                        <label for="input_name" class="required form-label">{{__('Subject/Task')}}</label>
                        <input type="text" id="input_name" name="subject" class="form-control form-control-solid" placeholder=""/>
                    </div>

                    {{-- Dates --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label class="required form-label">{{__('Start Date')}}</label>
                            <input type="text" placeholder="Pick Date" id="start_date" name="start_date"
                                   @if (!empty($task)) value="{{$task->start_date}}" @endif
                                   class="form-control form-control-solid flatpickr-input"/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{__('End Date')}}</label>
                            <input type="text" id="due_date" name="due_date"
                                   class="form-control form-control-solid"
                                   @if (!empty($task)) value="{{$task->due_date}}" @endif
                                   placeholder="Pick Date"/>
                        </div>
                    </div>

                    {{-- Assignment and Priority Row --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label for="contact_id" class="form-label">{{__('Assign To')}}</label>
                            <select class="form-select form-select-solid fw-bolder" id="contact_id" name="contact_id">
                                <option value="">{{__('None')}}</option>
                            @foreach ($users as $usertask)
                                <option value="{{$usertask->id}}"
                                        @if (!empty($task) && $task->contact_id === $usertask->id) selected @endif>
                                    {{$usertask->first_name}} {{$usertask->last_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                        <div class="col-md-6">
                            <label for="assignee_id" class="form-label">{{__('Assignee')}}</label>
                            <select class="form-select form-select-solid fw-bolder" id="assignee_id" name="assignee_id">
                                <option value="">{{__('None')}}</option>
                                @foreach ($users as $usertask)
                                    <option value="{{$usertask->id}}"
                                            @if (!empty($task) && $task->assignee_id === $usertask->id) selected @endif>
                                        {{$usertask->first_name}} {{$usertask->last_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Priority and Workspace Type Row --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="priority" class="form-label">{{__('Priority')}}</label>
                            <select class="form-select form-select-solid fw-bolder" id="priority" name="priority">
                                @foreach (config('task.priorities') as $key => $priority)
                                    <option value="{{ $key }}"
                                            @if (!empty($task) && $task->priority === $key) selected @elseif(empty($task) && $key === 'medium') selected @endif>
                                        {{ $priority['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="workspace_type" class="form-label">{{__('Workspace Type')}}</label>
                            <select class="form-select form-select-solid fw-bolder" id="workspace_type" name="workspace_type">
                                <option value="">{{__('Select Type')}}</option>
                                @foreach (config('task.workspace_types') as $key => $type)
                                    <option value="{{ $key }}"
                                            @if (!empty($task) && $task->workspace_type === $key) selected @endif>
                                        {{ $type['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Status Row --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="status" class="form-label">{{__('Status')}}</label>
                            <select class="form-select form-select-solid fw-bolder" id="status" name="status">
                                @foreach (config('task.statuses') as $key => $status)
                                    <option value="{{ $key }}"
                                            @if (!empty($task) && $task->status === $key) selected @elseif(empty($task) && $key === 'to_do') selected @endif>
                                        {{ $status['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>

                    {{-- Progress Row --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="progress" class="form-label">{{__('Progress (%)')}}</label>
                            <input type="number" id="progress" name="progress" 
                                   class="form-control form-control-solid" 
                                   min="0" max="100" 
                                   value="@if (!empty($task)){{$task->progress}}@else 0 @endif"
                                   placeholder="0"/>
                        </div>
                    </div>

                    {{-- Estimated Hours Row --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="estimated_hours" class="form-label">{{__('Estimated Hours')}}</label>
                            <input type="number" id="estimated_hours" name="estimated_hours" 
                                   class="form-control form-control-solid" 
                                   min="0" step="0.5"
                                   value="@if (!empty($task)){{$task->estimated_hours}}@endif"
                                   placeholder="0"/>
                        </div>
                        <div class="col-md-6">
                            <label for="tags" class="form-label">{{__('Tags (comma separated)')}}</label>
                            <input type="text" id="tags" name="tags" 
                                   class="form-control form-control-solid" 
                                   value="@if (!empty($task) && $task->tags){{ implode(', ', $task->tags) }}@endif"
                                   placeholder="tag1, tag2, tag3"/>
                        </div>
                    </div>


                    {{-- Description --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label for="description" class="form-label">{{__('Description')}}</label>
                                <textarea name="description" id="description"
                                          class="form-control form-control-solid"
                                          rows="7">@if (!empty($task)){{$task->description}}@endif</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="ms-3">
                    @csrf
                    <button type="submit" id="btn_submit" class="btn btn-info">{{__('Save')}}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                </div>
                <input type="hidden" name="task_id" id="task_id" value="">
            </form>
        </div>
    </div>
</div>

