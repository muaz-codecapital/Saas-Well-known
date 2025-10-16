@extends('layouts.primary')



@section('content')

    <div class="row">
        <div class="col">
            <h5 class="text-secondary">{{__('Tasks /Gantt Chart')}}</h5>
        </div>
        @include('tasks.tabs.tabs')
    </div>

    <div>
        <div class="card">
            <div class="card-body">
                <svg id="gantt">

                </svg>
            </div>

        </div>
    </div>
    @include('tasks.add-new')
    @include('tasks.add-status-model')
    @include('tasks.add-group')
@endsection

@section('script')


    <script>
        // jkanban init

        (function() {
            "use strict";
            var tasks = [
                    @foreach($tasks as $task)
                {
                    id: "{{$task->id}}",
                    name: '{{$task->subject}}',
                    start: '{{$task->start_date}}',
                    end: '{{$task->due_date}}',


                    @if($task->status === 'done')
                    progress: 100,

                    @elseif($task->status === 'in_review')
                    progress: 60,
                    @elseif($task->status === 'in_progress')
                    progress: 40,
                    @elseif($task->status === 'todo')
                    progress: 0,
                    @endif


                    // dependencies: 'Task 2, Task 3'
                },

                     @endforeach
            ]

            var gantt = new Gantt('#gantt', tasks, {
                // on_click: function (task) {
                //     console.log(task);
                // },
                // on_date_change: function(task, start, end) {
                //     console.log(task, start, end);
                // },
                // on_progress_change: function(task, progress) {
                //     console.log(task, progress);
                // },
                // on_view_change: function(mode) {
                //     console.log(mode);
                // }
            });
            // gantt.change_view_mode('Week');

        })();
    </script>
        @endsection
