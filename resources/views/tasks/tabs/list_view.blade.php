<div class="card-body mt-4 table-responsive  pt-0">
    <!--begin::Table-->
    <table class="table align-items-center mb-0" id="cloudonex_table">
        <!--begin::Table head-->
        <thead>
        <!--begin::Table row-->
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Subject/Task')}}</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Assigned To')}}</th>

            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Start Date')}}</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Due Date')}}</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Status')}}
            </th>
            @if(is_null($group))
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Workspace Name')}}
            </th>
            @endif
            <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end ">{{__('Actions')}}</th>
        </tr>
        </thead>

        <tbody>
        <!--begin::Table row-->

        @foreach( $tasks as  $task)

            <tr>
                <td class="">
                    <h6 class="text-sm font-weight-bold mb-0">{{ $task->subject}} </h6>
                </td>


                <td class=" text-sm fw-bolder mb-0">

                    <div class="d-flex">
                        <div class="avatar avatart-sm rounded-circle">
                            @if(isset($users[$task->contact_id]))
                                @if(!empty($users[$task->contact_id]->photo))
                                    <a href="javascript:" class="avatar avatar-sm rounded-circle"
                                       data-bs-toggle="tooltip" data-bs-placement="bottom"  title="{{$users[$task->contact_id]->first_name}}">
                                        <img src="{{PUBLIC_DIR}}/uploads/{{$users[$task->contact_id]->photo}}">
                                    </a>

                                @else
                                    <div class="avatar  avatar-sm rounded-circle bg-indigo"><p class=" mt-3 text-white text-uppercase">{{$users[$task->contact_id]->first_name[0]}}{{$users[$task->contact_id]->last_name[0]}}</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="text-sm fw-bold mt-2 ms-1 ">
                            @if(isset($users[$task->contact_id]))
                                {{$users[$task->contact_id]->first_name}} {{$users[$task->contact_id]->last_name}}

                            @endif
                        </div>
                    </div>



                </td>


                <td>
                    <p class="text-xs font-weight-bold text-dark mb-0">
                        @if(!empty($task->start_date))
                            {{(\App\Supports\DateSupport::parse($task->start_date))->format(config('app.date_time_format'))}}

                        @endif
                    </p>
                </td>
                <td>
                    <p class="text-xs font-weight-bold text-dark mb-0">
                        @if(!empty($task->due_date))
                            {{$task->due_date->format(config('app.date_time_format'))}}
                        @endif
                    </p>

                </td>
                @php
                    $taskStatuses = config('task.statuses'); // fetch statuses from config
                    $currentStatus = $task->status ?? 'todo';
                @endphp
                <td class="position-relative">
                    <div class="dropdown mt-2">
                        <button class="text-xs btn btn-sm {{ $taskStatuses[$currentStatus]['class'] }} dropdown-toggle"
                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __($taskStatuses[$currentStatus]['label']) }}
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"  style="z-index: 1050;">
                            @foreach($taskStatuses as $statusKey => $status)
                                <li>
                                    <a class="dropdown-item change_task_status"
                                       data-id="{{ $task->id }}"
                                       data-status="{{ $statusKey }}" href="#">
                                        {{ __('Mark as') }} {{ __($status['label']) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </td>
                @if(is_null($group))
                <td>
                    @if($task->group && !is_null($task->group))
                    <span class="btn btn-sm btn-primary">
                        {{ Str::title($task->group) }}
                    </span>
                    @endif
                </td>
                @endif
                <!--begin::Joined-->
                <!--begin::Action=-->
                <td class="text-end">

                    <!--begin::Menu-->
                    <div class="menu-item px-3">
                        <a href="#" class="btn btn-link text-dark px-3 mb-0 category_edit"
                           data-id="{{$task->id}}">{{__('Edit')}}</a>
                        <a href="/delete/task/{{$task->id}}" class="btn btn-link text-danger px-3 mb-0"
                           data-kt-users-table-filter="delete_row">{{__('Delete')}}</a>
                    </div>
                    <!--end::Menu-->
                </td>
                <!--end::Action=-->
            </tr>
        @endforeach

        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->

    @include('tasks.add-new')
    @include('tasks.add-status-model')
    @include('tasks.add-group')
</div>


