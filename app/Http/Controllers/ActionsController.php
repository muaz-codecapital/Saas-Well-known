<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Note;
use App\Models\Tag;
use App\Models\Projects;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActionsController extends BaseController
{
    public function notes()
    {
        // Allow notes functionality for basic features
        // if ($this->modules && !in_array("notes", $this->modules)) {
        //     abort(401);
        // }

        $notes = Note::where("workspace_id", $this->user->workspace_id)
            ->with('noteTags')
            ->orderBy("created_at", "desc")
            ->get();

        return \view("actions.notes", [
            "selected_navigation" => "notes",
            "notes" => $notes,
        ]);
    }

    public function addNote(Request $request)
    {
        // Allow notes functionality for basic features
        // if ($this->modules && !in_array("notes", $this->modules)) {
        //     abort(401);
        // }

        $note = false;

        if ($request->id) {
            $note = Note::where("workspace_id", $this->user->workspace_id)
                ->with('noteTags')
                ->where("id", $request->id)
                ->first();
        }

        // Get available tags for the form
        $availableTags = Tag::inWorkspace($this->user->workspace_id)->get();

        return \view("actions.add-note", [
            "selected_navigation" => "notes",
            "note" => $note,
            "availableTags" => $availableTags,
        ]);
    }

    public function viewNote(Request $request)
    {
        // Allow notes functionality for basic features
        // if ($this->modules && !in_array("notes", $this->modules)) {
        //     abort(401);
        // }

        $note = false;
        $users = User::all()
            ->keyBy("id")
            ->all();

        if ($request->id) {
            $note = Note::where("workspace_id", $this->user->workspace_id)
                ->where("id", $request->id)
                ->first();
        }

        return \view("actions.view-note", [
            "selected_navigation" => "notes",
            "note" => $note,
            "users" => $users,
        ]);
    }

    public function notePost(Request $request)
    {
        // Allow notes functionality regardless of modules setting for basic functionality
        // if ($this->modules && !in_array("notes", $this->modules)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Notes module is not enabled'
        //     ], 403);
        // }

        $validator = \Validator::make($request->all(), [
            "title" => "required|max:255",
            "id" => "nullable|integer",
            "topic" => "required|string|max:255",
            "notes" => "required|string",
            "tags" => "required|array|min:1",
            "tags.*" => "integer|exists:tags,id",
            "cover_photo" => "nullable|file|mimes:jpeg,png,jpg,gif,svg|max:4096",
            "reference_file" => "nullable|file|mimes:pdf,doc,docx,txt,xlsx,xls,ppt,pptx|max:10240",
            "workspace" => "nullable|string|max:100",
            "attachments" => "nullable|array",
            "attachments.*" => "file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,xlsx,xls,ppt,pptx|max:10240",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        // Find existing note or create new
        $note = $request->id
            ? Note::where("workspace_id", $this->user->workspace_id)
                ->where("id", $request->id)
                ->first()
            : new Note([
                'uuid' => Str::uuid(),
                'workspace_id' => $this->user->workspace_id,
            ]);

        // Upload cover photo
        if ($request->hasFile('cover_photo')) {
            if ($note->cover_photo) {
                \Storage::disk('uploads')->delete($note->cover_photo);
            }
            $note->cover_photo = $request->file('cover_photo')->store('media/covers', 'uploads');
        }

        // Upload reference file
        if ($request->hasFile('reference_file')) {
            if ($note->reference_file) {
                \Storage::disk('uploads')->delete($note->reference_file);
            }
            $note->reference_file = $request->file('reference_file')->store('media/references', 'uploads');
        }

        // Assign fields
        $note->title = $request->title;
        $note->topic = $request->topic;
        $note->notes = $request->notes;
        $note->admin_id = $this->user->id;

        // Workspace (as text)
        if ($request->filled('workspace')) {
            $note->workspace = trim($request->workspace);
        }

        // Save the note first to get an ID
        $note->save();

        // Handle tag relationships after the note is saved
        if ($request->filled('tags')) {
            $tagIds = $request->tags;
            
            // Get existing tag IDs to avoid double counting
            $existingTagIds = $note->noteTags()->pluck('tags.id')->toArray();
            
            // Sync tags with the note
            $note->noteTags()->sync($tagIds);
            
            // Update usage counts for new tags only
            $newTagIds = array_diff($tagIds, $existingTagIds);
            foreach ($newTagIds as $tagId) {
                $tag = Tag::find($tagId);
                if ($tag) {
                    $tag->incrementUsage();
                }
            }
        }

        // Handle attachments
        if ($request->hasFile('attachments')) {
            $attachments = $note->attachments ?? [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('media/attachments', 'uploads');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => 'attachment',
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_at' => now()->toISOString(),
                ];
            }
            $note->attachments = $attachments;
            $note->save(); // Save again to store attachments
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $note->load(['user', 'noteTags']),
                'message' => $note->wasRecentlyCreated ? 'Note created successfully!' : 'Note updated successfully!'
            ]);
        }

        return redirect("/notes")->with('success', 'Note saved successfully!');
    }

    public function deleteNote(Request $request, Note $note)
    {
        // Ensure note belongs to user's workspace
        if ($note->workspace_id !== $this->user->workspace_id) {
            abort(403);
        }

        // Delete the note
        $note->delete();

        // Handle AJAX requests
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully'
            ]);
        }

        return redirect('/notes')->with('success', 'Note deleted successfully');
    }
}
