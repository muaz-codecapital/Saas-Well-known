<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Note::where('workspace_id', $user->workspace_id);

        // Apply filters
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('tag')) {
            $query->withTag($request->tag);
        }

        if ($request->filled('workspace')) {
            $query->inWorkspace($request->workspace);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        $notes = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $notes,
            'message' => 'Notes retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'topic' => 'required|max:255',
            'notes' => 'required|string',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'reference_file' => 'nullable|file|mimes:pdf,doc,docx,txt,xlsx,xls,ppt,pptx|max:10240',
            'workspace' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,xlsx,xls,ppt,pptx|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        $user = auth()->user();

        $note = new Note([
            'uuid' => Str::uuid(),
            'workspace_id' => $user->workspace_id,
            'admin_id' => $user->id,
        ]);

        // Handle cover photo
        if ($request->hasFile('cover_photo')) {
            $note->cover_photo = $request->file('cover_photo')->store('media/covers', 'uploads');
        }

        // Handle reference file
        if ($request->hasFile('reference_file')) {
            $note->reference_file = $request->file('reference_file')->store('media/references', 'uploads');
        }

        // Assign basic fields
        $note->title = $request->title;
        $note->topic = $request->topic;
        $note->notes = $request->notes;

        // Handle workspace
        if ($request->filled('workspace')) {
            $note->workspace = $request->workspace;
        }

        // Handle tags
        if ($request->filled('tags')) {
            $tags = collect(explode(',', $request->tags))
                ->map(fn($tag) => trim(strtolower($tag)))
                ->filter()
                ->unique()
                ->values()
                ->toArray();
            $note->tags = $tags;
        }

        // Handle attachments
        if ($request->hasFile('attachments')) {
            $attachments = [];
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
        }

        $note->save();

        return response()->json([
            'success' => true,
            'data' => $note->load('user'),
            'message' => 'Note created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        // Check if user owns the note
        if ($note->workspace_id !== auth()->user()->workspace_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $note->load('user'),
            'message' => 'Note retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        // Check if user owns the note
        if ($note->workspace_id !== auth()->user()->workspace_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'topic' => 'required|max:255',
            'notes' => 'required|string',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'reference_file' => 'nullable|file|mimes:pdf,doc,docx,txt,xlsx,xls,ppt,pptx|max:10240',
            'workspace' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        // Handle cover photo
        if ($request->hasFile('cover_photo')) {
            // Delete old cover photo if exists
            if ($note->cover_photo) {
                \Storage::disk('uploads')->delete($note->cover_photo);
            }
            $note->cover_photo = $request->file('cover_photo')->store('media/covers', 'uploads');
        }

        // Handle reference file
        if ($request->hasFile('reference_file')) {
            // Delete old reference file if exists
            if ($note->reference_file) {
                \Storage::disk('uploads')->delete($note->reference_file);
            }
            $note->reference_file = $request->file('reference_file')->store('media/references', 'uploads');
        }

        // Update fields
        $note->title = $request->title;
        $note->topic = $request->topic;
        $note->notes = $request->notes;

        if ($request->filled('workspace')) {
            $note->workspace = $request->workspace;
        }

        if ($request->filled('tags')) {
            $tags = collect(explode(',', $request->tags))
                ->map(fn($tag) => trim(strtolower($tag)))
                ->filter()
                ->unique()
                ->values()
                ->toArray();
            $note->tags = $tags;
        }

        $note->save();

        return response()->json([
            'success' => true,
            'data' => $note->load('user'),
            'message' => 'Note updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        // Check if user owns the note
        if ($note->workspace_id !== auth()->user()->workspace_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete associated files
        if ($note->cover_photo) {
            \Storage::disk('uploads')->delete($note->cover_photo);
        }

        if ($note->reference_file) {
            \Storage::disk('uploads')->delete($note->reference_file);
        }

        if ($note->attachments) {
            foreach ($note->attachments as $attachment) {
                if (isset($attachment['path'])) {
                    \Storage::disk('uploads')->delete($attachment['path']);
                }
            }
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ]);
    }

    /**
     * Add attachment to note.
     */
    public function addAttachment(Request $request, Note $note)
    {
        // Check if user owns the note
        if ($note->workspace_id !== auth()->user()->workspace_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,gif,xlsx,xls,ppt,pptx|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        $file = $request->file('file');
        $note->addAttachment($file);

        return response()->json([
            'success' => true,
            'data' => $note->load('user'),
            'message' => 'Attachment added successfully'
        ]);
    }

    /**
     * Remove attachment from note.
     */
    public function removeAttachment(Request $request, Note $note, $attachmentIndex)
    {
        // Check if user owns the note
        if ($note->workspace_id !== auth()->user()->workspace_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $note->removeAttachment($attachmentIndex);

        return response()->json([
            'success' => true,
            'data' => $note->load('user'),
            'message' => 'Attachment removed successfully'
        ]);
    }
}
