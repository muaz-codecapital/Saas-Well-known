<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Note;
use App\Models\Projects;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActionsController extends BaseController
{
    public function notes()
    {
        if ($this->modules && !in_array("notes", $this->modules)) {
            abort(401);
        }

        $notes = Note::where("workspace_id", $this->user->workspace_id)->get();

        return \view("actions.notes", [
            "selected_navigation" => "notes",
            "notes" => $notes,
        ]);
    }

    public function addNote(Request $request)
    {
        if ($this->modules && !in_array("notes", $this->modules)) {
            abort(401);
        }

        $note = false;

        if ($request->id) {
            $note = Note::where("workspace_id", $this->user->workspace_id)
                ->where("id", $request->id)
                ->first();
        }

        return \view("actions.add-note", [
            "selected_navigation" => "notes",
            "note" => $note,
        ]);
    }

    public function viewNote(Request $request)
    {
        if ($this->modules && !in_array("notes", $this->modules)) {
            abort(401);
        }

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
        if ($this->modules && !in_array("notes", $this->modules)) {
            abort(401);
        }

        $request->validate([
            "title" => "required|max:150",
            "id" => "nullable|integer",
            "topic" => "required|string",
            "cover_photo" => "nullable|file|mimes:jpeg,png,jpg,gif,svg|max:4096",
            "reference_file" => "nullable|file|max:5120",
            "workspace" => "nullable|string|max:100", // workspace name (text)
            "tags" => "nullable|string", // comma-separated or JSON string
        ]);

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
            $note->cover_photo = $request->file('cover_photo')->store('media/covers', 'uploads');
        }

        // Upload reference file
        if ($request->hasFile('reference_file')) {
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

        // Tags (as JSON)
        if ($request->filled('tags')) {
            $tags = collect(explode(',', $request->tags))
                ->map(fn($t) => trim(strtolower($t)))
                ->filter()
                ->unique()
                ->values()
                ->toArray();

            $note->tags = json_encode($tags);
        }

        $note->save();

        return redirect("/notes")->with('success', 'Note saved successfully!');
    }
}
