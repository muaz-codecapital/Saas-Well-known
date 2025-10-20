<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TagController extends BaseController
{
    /**
     * Display a listing of tags
     */
    public function index()
    {
        $tags = Tag::inWorkspace($this->user->workspace_id)
            ->popular()
            ->paginate(20);

        return view('tags.index', [
            'selected_navigation' => 'tags',
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new tag
     */
    public function create()
    {
        return view('tags.create', [
            'selected_navigation' => 'tags',
        ]);
    }

    /**
     * Store a newly created tag
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name,NULL,id,workspace_id,' . $this->user->workspace_id,
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tag = Tag::create([
            'workspace_id' => $this->user->workspace_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color ?: '#667eea',
            'description' => $request->description,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $tag,
                'message' => 'Tag created successfully'
            ]);
        }

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully!');
    }

    /**
     * Display the specified tag
     */
    public function show(Request $request, Tag $tag)
    {
        // Ensure tag belongs to user's workspace
        if ($tag->workspace_id !== $this->user->workspace_id) {
            abort(403);
        }

        // Handle AJAX requests for editing
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $tag,
            ]);
        }

        $notes = $tag->notes()
            ->where('workspace_id', $this->user->workspace_id)
            ->paginate(15);

        return view('tags.show', [
            'selected_navigation' => 'tags',
            'tag' => $tag,
            'notes' => $notes,
        ]);
    }

    /**
     * Show the form for editing the specified tag
     */
    public function edit(Tag $tag)
    {
        // Ensure tag belongs to user's workspace
        if ($tag->workspace_id !== $this->user->workspace_id) {
            abort(403);
        }

        return view('tags.edit', [
            'selected_navigation' => 'tags',
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified tag
     */
    public function update(Request $request, Tag $tag)
    {
        // Ensure tag belongs to user's workspace
        if ($tag->workspace_id !== $this->user->workspace_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id . ',id,workspace_id,' . $this->user->workspace_id,
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color ?: '#667eea',
            'description' => $request->description,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $tag,
                'message' => 'Tag updated successfully'
            ]);
        }

        return redirect()->route('tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified tag
     */
    public function destroy(Tag $tag)
    {
        // Ensure tag belongs to user's workspace
        if ($tag->workspace_id !== $this->user->workspace_id) {
            abort(403);
        }

        // Check if tag is being used by any notes
        if ($tag->notes()->count() > 0) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete tag that is being used by notes'
                ], 422);
            }

            return redirect()->back()
                ->with('error', 'Cannot delete tag that is being used by notes');
        }

        $tag->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tag deleted successfully'
            ]);
        }

        return redirect()->route('tags.index')
            ->with('success', 'Tag deleted successfully!');
    }

    /**
     * Get tags for AJAX requests (for dropdowns, etc.)
     */
    public function getTags(Request $request)
    {
        $query = Tag::inWorkspace($this->user->workspace_id);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $tags = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $tags,
        ]);
    }

    /**
     * Create a new tag via AJAX
     */
    public function createTag(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name,NULL,id,workspace_id,' . $this->user->workspace_id,
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        $tag = Tag::create([
            'workspace_id' => $this->user->workspace_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color ?: '#667eea',
        ]);

        return response()->json([
            'success' => true,
            'data' => $tag,
            'message' => 'Tag created successfully'
        ]);
    }
}