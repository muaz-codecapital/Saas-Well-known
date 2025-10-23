<?php

namespace App\Http\Controllers;

use App\Models\ProductPlanning;
use App\Models\Product;
use App\Models\Department;
use App\Models\User;
use App\Models\ProductMilestone;
use App\Models\ProductFeature;
use App\Models\ProductEpic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductPlanningController extends BaseController
{
    public function index()
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        return redirect()->route('admin.product-planning.list');
    }

    public function list(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $view_type = $request->view_type ?? "list";
        $status = $request->status;
        $product_id = $request->product_id;
        $department_id = $request->department_id;
        $group_type = $request->group_type;
        $group_id = $request->group_id;
        $assigned_to = $request->assigned_to;
        $priority = $request->priority;
        $search = $request->search;

        $query = ProductPlanning::byWorkspace($this->user->workspace_id)
            ->with(['product', 'department', 'assignedUser', 'creator']);

        // Apply filters
        if ($status) {
            $query->where('status', $status);
        }

        if ($product_id) {
            $query->where('product_id', $product_id);
        }

        if ($department_id) {
            $query->where('department_id', $department_id);
        }

        if ($group_type && $group_id) {
            $query->where('group_type', $group_type)->where('group_id', $group_id);
        }

        if ($assigned_to) {
            $query->where('assigned_to', $assigned_to);
        }

        if ($priority) {
            $query->where('priority', $priority);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort_by = $request->sort_by ?? 'created_at';
        $sort_order = $request->sort_order ?? 'desc';

        switch ($sort_by) {
            case 'title':
                $query->orderBy('title', $sort_order);
                break;
            case 'status':
                $query->orderBy('status', $sort_order);
                break;
            case 'priority':
                $query->orderBy('priority', $sort_order);
                break;
            case 'due_date':
                $query->orderBy('due_date', $sort_order);
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', $sort_order);
                break;
        }

        $items = $query->paginate(20);

        $products = Product::byWorkspace($this->user->workspace_id)->active()->get();
        $departments = Department::byWorkspace($this->user->workspace_id)->active()->get();
        $users = User::where('workspace_id', $this->user->workspace_id)->get();

        // Get group items for filtering
        $milestones = ProductMilestone::where('workspace_id', $this->user->workspace_id)->get();
        $features = ProductFeature::where('workspace_id', $this->user->workspace_id)->get();
        $epics = ProductEpic::where('workspace_id', $this->user->workspace_id)->get();

        return view("product-planning.list", [
            "selected_navigation" => "product_planning",
            "items" => $items,
            "products" => $products,
            "departments" => $departments,
            "users" => $users,
            "milestones" => $milestones,
            "features" => $features,
            "epics" => $epics,
            "view_type" => $view_type,
            "current_filters" => $request->only(['status', 'product_id', 'department_id', 'group_type', 'group_id', 'assigned_to', 'priority', 'search'])
        ]);
    }

    public function kanban(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $product_id = $request->product_id;
        $department_id = $request->department_id;

        $query = ProductPlanning::byWorkspace($this->user->workspace_id)
            ->with(['product', 'department', 'assignedUser', 'creator']);

        if ($product_id) {
            $query->where('product_id', $product_id);
        }

        if ($department_id) {
            $query->where('department_id', $department_id);
        }

        $items = $query->get()->groupBy('status');

        $products = Product::byWorkspace($this->user->workspace_id)->active()->get();
        $departments = Department::byWorkspace($this->user->workspace_id)->active()->get();
        $users = User::where('workspace_id', $this->user->workspace_id)->get()->keyBy('id');

        return view("product-planning.kanban", [
            "selected_navigation" => "product_planning",
            "items" => $items,
            "products" => $products,
            "departments" => $departments,
            "users" => $users,
        ]);
    }


    public function create(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $products = Product::byWorkspace($this->user->workspace_id)->active()->get();
        $departments = Department::byWorkspace($this->user->workspace_id)->active()->get();
        $users = User::where('workspace_id', $this->user->workspace_id)->get();

        // Get group items
        $milestones = ProductMilestone::where('workspace_id', $this->user->workspace_id)->get();
        $features = ProductFeature::where('workspace_id', $this->user->workspace_id)->get();
        $epics = ProductEpic::where('workspace_id', $this->user->workspace_id)->get();

        return view("product-planning.create", [
            "selected_navigation" => "product_planning",
            "products" => $products,
            "departments" => $departments,
            "users" => $users,
            "milestones" => $milestones,
            "features" => $features,
            "epics" => $epics,
        ]);
    }

    public function store(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:idea,validation,in_development,testing,released,archived',
            'priority' => 'required|in:low,medium,high,urgent',
            'product_id' => 'nullable|exists:products,id',
            'department_id' => 'nullable|exists:departments,id',
            'group_type' => 'nullable|in:milestone,feature,epic',
            'group_id' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_to' => 'nullable|exists:users,id',
            'estimated_hours' => 'nullable|integer|min:0',
            'tags' => 'nullable|array',
        ]);

        $item = ProductPlanning::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'product_id' => $request->product_id,
            'department_id' => $request->department_id,
            'group_type' => $request->group_type,
            'group_id' => $request->group_id,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'estimated_hours' => $request->estimated_hours,
            'tags' => $request->tags,
            'workspace_id' => $this->user->workspace_id,
            'created_by' => $this->user->id,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product planning item created successfully',
                'item' => $item->load(['product', 'department', 'assignedUser'])
            ]);
        }

        return redirect()->back()->with('success', 'Product planning item created successfully');
    }

    public function show($id)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $item = ProductPlanning::byWorkspace($this->user->workspace_id)
            ->with(['product', 'department', 'assignedUser', 'creator'])
            ->findOrFail($id);

        return view("product-planning.show", [
            "selected_navigation" => "product_planning",
            "item" => $item,
        ]);
    }

    public function edit($id)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $item = ProductPlanning::byWorkspace($this->user->workspace_id)->findOrFail($id);

        $products = Product::byWorkspace($this->user->workspace_id)->active()->get();
        $departments = Department::byWorkspace($this->user->workspace_id)->active()->get();
        $users = User::where('workspace_id', $this->user->workspace_id)->get();

        // Get group items
        $milestones = ProductMilestone::where('workspace_id', $this->user->workspace_id)->get();
        $features = ProductFeature::where('workspace_id', $this->user->workspace_id)->get();
        $epics = ProductEpic::where('workspace_id', $this->user->workspace_id)->get();

        return view("product-planning.edit", [
            "selected_navigation" => "product_planning",
            "item" => $item,
            "products" => $products,
            "departments" => $departments,
            "users" => $users,
            "milestones" => $milestones,
            "features" => $features,
            "epics" => $epics,
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $item = ProductPlanning::byWorkspace($this->user->workspace_id)->findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:idea,validation,in_development,testing,released,archived',
            'priority' => 'required|in:low,medium,high,urgent',
            'product_id' => 'nullable|exists:products,id',
            'department_id' => 'nullable|exists:departments,id',
            'group_type' => 'nullable|in:milestone,feature,epic',
            'group_id' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_to' => 'nullable|exists:users,id',
            'estimated_hours' => 'nullable|integer|min:0',
            'progress' => 'nullable|integer|min:0|max:100',
            'actual_hours' => 'nullable|integer|min:0',
            'tags' => 'nullable|array',
        ]);

        $item->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'product_id' => $request->product_id,
            'department_id' => $request->department_id,
            'group_type' => $request->group_type,
            'group_id' => $request->group_id,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'estimated_hours' => $request->estimated_hours,
            'progress' => $request->progress ?? $item->progress,
            'actual_hours' => $request->actual_hours ?? $item->actual_hours,
            'tags' => $request->tags,
            'updated_by' => $this->user->id,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product planning item updated successfully',
                'item' => $item->load(['product', 'department', 'assignedUser'])
            ]);
        }

        return redirect()->back()->with('success', 'Product planning item updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $item = ProductPlanning::byWorkspace($this->user->workspace_id)->findOrFail($id);
        $item->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product planning item deleted successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Product planning item deleted successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $request->validate([
            'status' => 'required|in:idea,validation,in_development,testing,released,archived',
        ]);

        $item = ProductPlanning::byWorkspace($this->user->workspace_id)->findOrFail($id);
        $item->update([
            'status' => $request->status,
            'updated_by' => $this->user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'item' => $item->load(['product', 'department', 'assignedUser', 'creator'])
        ]);
    }

    public function getItem($id)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $item = ProductPlanning::byWorkspace($this->user->workspace_id)
            ->with(['product', 'department', 'assignedUser', 'creator'])
            ->findOrFail($id);

        return response()->json($item);
    }

    public function bulkUpdateStatus(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:product_plannings,id',
            'status' => 'required|in:idea,validation,in_development,testing,released,archived',
        ]);

        ProductPlanning::byWorkspace($this->user->workspace_id)
            ->whereIn('id', $request->ids)
            ->update([
                'status' => $request->status,
                'updated_by' => $this->user->id,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated for selected items'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:product_plannings,id',
        ]);

        ProductPlanning::byWorkspace($this->user->workspace_id)
            ->whereIn('id', $request->ids)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected items deleted successfully'
        ]);
    }

    public function storeProduct(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'version' => 'nullable|string|max:50',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'version' => $request->version ?: '1.0.0',
            'workspace_id' => $this->user->workspace_id,
            'created_by' => $this->user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product
        ]);
    }

    public function storeDepartment(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $department = Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'manager_id' => $request->manager_id,
            'workspace_id' => $this->user->workspace_id,
            'created_by' => $this->user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully',
            'department' => $department
        ]);
    }

    public function storeMilestone(Request $request)
    {
        if ($this->modules && !in_array("product_planning", $this->modules)) {
            abort(401);
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $milestone = ProductMilestone::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'product_id' => $request->product_id,
            'workspace_id' => $this->user->workspace_id,
            'created_by' => $this->user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Milestone created successfully',
            'milestone' => $milestone
        ]);
    }
}
