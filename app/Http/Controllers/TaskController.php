<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends BaseController
{

    public function gantt()
    {
//        if ($this->modules && !in_array("notes", $this->modules)) {
//            abort(401);
//        }

        $tasks = Task::where("workspace_id", $this->user->workspace_id)
            ->get();
//            ->groupBy("status")
//            ->all();


        $users = User::where(
            "workspace_id",
            $this->user->workspace_id
        )->get()->keyBy("id")
            ->all();


        return \view("tasks.gantt", [
            "selected_navigation" => "todos",
            "tasks" => $tasks,
            "users" => $users,
        ]);
    }
    public function kanban()
    {
//        if ($this->modules && !in_array("notes", $this->modules)) {
//            abort(401);
//        }

        $tasks = Task::where("workspace_id", $this->user->workspace_id)
            ->get()
            ->groupBy("status")
            ->all();


        $users = User::where(
            "workspace_id",
            $this->user->workspace_id
        )->get()->keyBy("id")
            ->all();


        return \view("tasks.kanban", [
            "selected_navigation" => "todos",
            "tasks" => $tasks,
            "users" => $users,
        ]);
    }
    public function setStatus(Request $request)
    {
//        if ($this->modules && !in_array("notes", $this->modules)) {
//            abort(401);
//        }

        $request->validate([
            "id" => "required|integer",
        ]);

        $task = Task::where("workspace_id", $this->user->workspace_id)
            ->where("id", $request->id)
            ->first();

        if ($task) {
            $task->status = $request->status;
            $task->save();
        }

    }
    public function tasksAction($action, Request $request)
    {
        switch ($action) {
            case "list":
                if ($this->modules && !in_array("to_dos", $this->modules)) {
                    abort(401);
                }
                $task = false;
                $group = $request->get("group");
                $view_type = $request->view_type ?? "list";

                if ($request->id) {
                    $task = Task::where(
                        "workspace_id",
                        $this->user->workspace_id
                    )
                        ->where("id", $request->id)
                        ->when($group, function ($query, $group) {
                            return $query->where("group", $group);
                        })
                        ->first();
                }

                $tasks = Task::where("workspace_id", $this->user->workspace_id)
                    ->when($group, function ($query, $group) {
                        return $query->where("group", $group);
                    })
                    ->get();
                $users = User::where(
                    "workspace_id",
                    $this->user->workspace_id
                )->get()->keyBy("id")
                    ->all();

                return \view("tasks.list", [
                    "selected_navigation" => "todos",
                    "tasks" => $tasks,
                    "task" => $task,
                    "users" => $users,
                    "view_type" => $view_type,
                    'group' => $group,
                ]);

                break;

            case "task.json":
                $request->validate([
                    "id" => "required|integer",
                ]);
                if ($request->id) {
                    $task = Task::where(
                        "workspace_id",
                        $this->user->workspace_id
                    )
                        ->where("id", $request->id)
                        ->first();
                }

                if ($task) {
                    return response($task);
                }

                break;
        }
    }

    public function tasksSave($action, Request $request)
    {
        switch ($action) {
            case "task":
                if ($this->modules && !in_array("to_dos", $this->modules)) {
                    abort(401);
                }

                $request->validate([
                    "subject" => "required|max:150",
                    "contact_id" => "nullable|integer",
                ]);
                $task = false;

                if ($request->task_id) {
                    $task = Task::where(
                        "workspace_id",
                        $this->user->workspace_id
                    )
                        ->where("id", $request->task_id)
                        ->first();
                }

                if (!$task) {
                    $task = new Task();
                    $task->uuid = Str::uuid();
                    $task->workspace_id = $this->user->workspace_id;
                    $task->status = "todo";
                }

                $task->subject = $request->subject;
                $task->contact_id = $request->contact_id;
                $task->due_date = $request->due_date;
                $task->start_date = $request->start_date;
                $task->description = $request->description;
                $task->group = $request->group ?? null;

                $task->save();

                break;

            case "change-status":
                ray($request->all());

                $request->validate([
                    "id" => "required|integer",
                ]);

                $task = Task::where("workspace_id", $this->user->workspace_id)
                    ->where("id", $request->id)
                    ->first();

                if ($task) {
                    $task->status = $request->status;
                    $task->save();
                }
                break;
        }
    }

    public function addStatus(Request $request)
    {
        $request->validate([
            'status_name' => 'required|string|max:50',
            'status_class' => 'required|string',
        ]);

        $configPath = config_path('task.php');
        $statuses = config('task.statuses');
        $newKey = strtolower(str_replace(' ', '_', $request->status_name));
        if(isset($statuses[$newKey])){
            return response()->json(['success'=>false, 'message'=>'Status already exists']);
        }
        $statuses[$newKey] = [
            'label' => $request->status_name,
            'class' => $request->status_class,
        ];
        $content = "<?php\n\nreturn [\n    'statuses' => " . var_export($statuses, true) . ",\n];\n";

        file_put_contents($configPath, $content);

        return response()->json(['success'=>true]);
    }

    public function addWorkSpace(Request $request)
    {
        $request->validate([
            'workspace_name' => 'required|string|max:50',
        ]);
        $configPath = config_path('groups.php');
        $groups = config('groups.groups');
        $newKey = strtolower(str_replace(' ', '_', $request->workspace_name));
        if (isset($groups[$newKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Group already exists',
            ]);
        }
        $groups[$newKey] = \Illuminate\Support\Str::title(str_replace('_', ' ', $newKey));
        $content = "<?php\n\nreturn [\n    'groups' => " . var_export($groups, true) . ",\n];\n";
        file_put_contents($configPath, $content);
        return response()->json([
            'success' => true,
            'message' => 'Group added successfully',
        ]);
    }

}
