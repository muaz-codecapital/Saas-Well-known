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

                    {{-- Assign User --}}
                    <div class="mb-1 mt-2">
                        <label for="contact" class="form-label">{{__('Assign To')}}</label>
                        <select class="form-select form-select-solid fw-bolder" id="contact" name="contact_id">
                            <option value="0">{{__('None')}}</option>
                            @foreach ($users as $usertask)
                                <option value="{{$usertask->id}}"
                                        @if (!empty($task) && $task->contact_id === $usertask->id) selected @endif>
                                    {{$usertask->first_name}} {{$usertask->last_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Groups Dropdown --}}
                    <div class="mb-2">
                        <label for="group" class="form-label">{{__('Group')}}</label>
                        <select class="form-select form-select-solid fw-bolder" id="group" name="group">
                            @foreach (config('groups.groups') as $key => $label)
                                <option value="{{ $key }}"
                                        @if (!empty($task) && $task->group === $key) selected @endif>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
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
                    <button type="button" class="btn bg-pink-light text-danger" data-bs-dismiss="modal">{{__('Close')}}</button>
                </div>
                <input type="hidden" name="task_id" id="task_id" value="">
            </form>
        </div>
    </div>
</div>
