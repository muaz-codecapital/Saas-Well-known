<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends BaseController
{

    public function kanban(Request $request)
    {
//        if ($this->modules && !in_array("notes", $this->modules)) {
//            abort(401);
//        }

        $workspace_type = $request->get("workspace_type");
        $priority = $request->get("priority");

        $tasks = Task::where("workspace_id", $this->user->workspace_id)
            ->when($workspace_type, function ($query, $workspace_type) {
                return $query->where("workspace_type", $workspace_type);
            })
            ->when($priority, function ($query, $priority) {
                return $query->where("priority", $priority);
            })
            ->with(['assignee', 'contact', 'owner'])
            ->get();

        $users = User::where(
            "workspace_id",
            $this->user->workspace_id
        )->get()->keyBy("id")
            ->all();

        // Get configuration data
        $workspaceTypes = config('task.workspace_types');
        $taskStatuses = config('task.statuses');
        $taskPriorities = config('task.priorities');

        return \view("tasks.kanban", [
            "selected_navigation" => "todos",
            "tasks" => $tasks,
            "users" => $users,
            'workspace_type' => $workspace_type,
            'priority' => $priority,
            'workspaceTypes' => $workspaceTypes,
            'taskStatuses' => $taskStatuses,
            'taskPriorities' => $taskPriorities,
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
                $workspace_type = $request->get("workspace_type");
                $status = $request->get("status");
                $priority = $request->get("priority");
                $view_type = $request->view_type ?? "list";

                if ($request->id) {
                    $task = Task::where(
                        "workspace_id",
                        $this->user->workspace_id
                    )
                        ->where("id", $request->id)
                        ->when($workspace_type, function ($query, $workspace_type) {
                            return $query->where("workspace_type", $workspace_type);
                        })
                        ->first();
                }

                $tasks = Task::where("workspace_id", $this->user->workspace_id)
                    ->when($workspace_type, function ($query, $workspace_type) {
                        return $query->where("workspace_type", $workspace_type);
                    })
                    ->when($status, function ($query, $status) {
                        return $query->where("status", $status);
                    })
                    ->when($priority, function ($query, $priority) {
                        return $query->where("priority", $priority);
                    })
                    ->with(['assignee', 'contact', 'owner'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
                $users = User::where(
                    "workspace_id",
                    $this->user->workspace_id
                )->get()->keyBy("id")
                    ->all();

                // Get workspace types for filtering
                $workspaceTypes = config('task.workspace_types');
                $taskStatuses = config('task.statuses');
                $taskPriorities = config('task.priorities');

                return \view("tasks.list", [
                    "selected_navigation" => "todos",
                    "tasks" => $tasks,
                    "task" => $task,
                    "users" => $users,
                    "view_type" => $view_type,
                    'workspace_type' => $workspace_type,
                    'status' => $status,
                    'priority' => $priority,
                    'workspaceTypes' => $workspaceTypes,
                    'taskStatuses' => $taskStatuses,
                    'taskPriorities' => $taskPriorities,
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
                    "assignee_id" => "nullable|integer",
                    "priority" => "nullable|string",
                    "workspace_type" => "nullable|string",
                    "estimated_hours" => "nullable|integer|min:0",
                    "progress" => "nullable|integer|min:0|max:100",
                    "tags" => "nullable|string",
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
                    $task->status = "to_do";
                    $task->owner_id = auth()->id();
                }

                $task->subject = $request->subject;
                $task->contact_id = $request->contact_id;
                $task->assignee_id = $request->assignee_id;
                $task->due_date = $request->due_date;
                $task->start_date = $request->start_date;
                $task->description = $request->description;
                $task->priority = $request->priority ?? 'medium';
                $task->workspace_type = $request->workspace_type;
                $task->estimated_hours = $request->estimated_hours;
                $task->progress = $request->progress ?? 0;
                
                // Handle tags if provided
                if ($request->has('tags')) {
                    $tags = is_string($request->tags) ? explode(',', $request->tags) : $request->tags;
                    $task->tags = array_map('trim', $tags);
                }

                $task->save();

                break;

            case "change-status":
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
            'status_color' => 'nullable|string',
            'status_icon' => 'nullable|string',
        ]);

        $configPath = config_path('task.php');
        $config = config('task');
        $statuses = $config['statuses'];
        $newKey = strtolower(str_replace(' ', '_', $request->status_name));
        
        if(isset($statuses[$newKey])){
            return response()->json(['success'=>false, 'message'=>'Status already exists']);
        }
        
        $statuses[$newKey] = [
            'label' => $request->status_name,
            'class' => str_replace('btn-', '', $request->status_class),
            'color' => $request->status_color ?? $this->getColorFromClass($request->status_class),
            'icon' => $request->status_icon ?? 'circle',
        ];
        
        $config['statuses'] = $statuses;
        $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";

        file_put_contents($configPath, $content);

        return response()->json(['success'=>true, 'message'=>'Status added successfully']);
    }

    private function getColorFromClass($class)
    {
        $colors = [
            'btn-primary' => '#667eea',
            'btn-secondary' => '#8392ab',
            'btn-success' => '#11998e',
            'btn-danger' => '#ea0606',
            'btn-warning' => '#fbcf33',
            'btn-info' => '#17c1e8',
            'btn-dark' => '#344767',
        ];
        
        return $colors[$class] ?? '#8392ab';
    }



    public function quickUpdateStatus(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        $task = Task::where('workspace_id', $this->user->workspace_id)
            ->where('id', $request->task_id)
            ->first();

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found']);
        }

        $task->status = $request->status;
        $task->save();

        return response()->json([
            'success' => true, 
            'message' => 'Task status updated successfully',
            'task' => $task->load(['assignee', 'contact', 'owner'])
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $task = Task::where('workspace_id', $this->user->workspace_id)
            ->where('id', $id)
            ->first();

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }

        $task->status = $request->status;
        $task->save();

        return response()->json([
            'success' => true, 
            'message' => 'Task status updated successfully',
            'task' => $task->load(['assignee', 'contact', 'owner'])
        ]);
    }

}
