<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'workspace_id',
        'admin_id',
        'title',
        'topic',
        'notes',
        'cover_photo',
        'reference_file',
        'workspace',
        'tags',
        'attachments',
        'date',
    ];

    protected $casts = [
        'tags' => 'array',
        'attachments' => 'array',
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created the note
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the tags associated with the note
     */
    public function noteTags()
    {
        return $this->belongsToMany(Tag::class, 'note_tag', 'note_id', 'tag_id');
    }

    /**
     * Get cover photo URL
     */
    public function getCoverPhotoUrlAttribute()
    {
        if ($this->cover_photo) {
            return asset('public/uploads/' . $this->cover_photo);
        }
        return null;
    }

    /**
     * Get reference file URL
     */
    public function getReferenceFileUrlAttribute()
    {
        if ($this->reference_file) {
            return asset('public/uploads/' . $this->reference_file);
        }
        return null;
    }

    /**
     * Get attachments with URLs
     */
    public function getAttachmentsWithUrlsAttribute()
    {
        if (!$this->attachments) {
            return [];
        }

        return collect($this->attachments)->map(function ($attachment) {
            if (isset($attachment['path'])) {
                $attachment['url'] = asset('public/uploads/' . $attachment['path']);
            }
            return $attachment;
        })->toArray();
    }

    /**
     * Add an attachment to the note
     */
    public function addAttachment($file, $type = 'attachment')
    {
        $path = $file->store('media/attachments', 'uploads');

        $attachments = $this->attachments ?? [];

        $attachments[] = [
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'type' => $type,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'uploaded_at' => now()->toISOString(),
        ];

        $this->attachments = $attachments;
        $this->save();

        return $attachments;
    }

    /**
     * Remove an attachment from the note
     */
    public function removeAttachment($attachmentIndex)
    {
        $attachments = $this->attachments ?? [];

        if (isset($attachments[$attachmentIndex])) {
            $attachment = $attachments[$attachmentIndex];

            // Delete the file from storage
            if (isset($attachment['path'])) {
                Storage::disk('uploads')->delete($attachment['path']);
            }

            // Remove from attachments array
            unset($attachments[$attachmentIndex]);
            $this->attachments = array_values($attachments);
            $this->save();
        }

        return $this->attachments;
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope for searching notes
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('topic', 'like', "%{$search}%")
              ->orWhere('notes', 'like', "%{$search}%");
        });
    }

    /**
     * Scope for filtering by tags
     */
    public function scopeWithTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Scope for filtering by workspace
     */
    public function scopeInWorkspace($query, $workspace)
    {
        return $query->where('workspace', $workspace);
    }

    /**
     * Get clean tags array for display
     */
    public function getCleanTagsAttribute()
    {
        return $this->getDisplayTags();
    }

    /**
     * Get display tags (handles both relationship and old format)
     */
    public function getDisplayTags()
    {
        // First try to get tags from the relationship
        if ($this->relationLoaded('noteTags') && $this->noteTags && $this->noteTags->isNotEmpty()) {
            return $this->noteTags->pluck('name')->toArray();
        }

        // Fallback to old format handling - use getRawOriginal to get the actual database value
        $tagsData = $this->getRawOriginal('tags');
        $tagsArray = [];
        
        // Handle different tag formats
        if (is_array($tagsData)) {
            $tagsArray = $tagsData;
        } elseif (is_string($tagsData)) {
            // Try to decode JSON first
            $decoded = json_decode($tagsData, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $tagsArray = $decoded;
            } else {
                // If not JSON, treat as comma-separated string
                $tagsArray = array_map('trim', explode(',', $tagsData));
            }
        }
        
        $cleanTags = [];
        foreach ($tagsArray as $tag) {
            $tagValue = $this->extractTagValue($tag);
            if (!empty($tagValue)) {
                $cleanTags[] = $tagValue;
            }
        }
        
        return $cleanTags;
    }

    /**
     * Extract clean tag value from various formats
     */
    private function extractTagValue($tag)
    {
        $tagValue = '';
        
        if (is_array($tag)) {
            // Handle array format like {"value": "tag name"}
            if (isset($tag['value'])) {
                $tagValue = $tag['value'];
            } elseif (isset($tag['tag'])) {
                $tagValue = $tag['tag'];
            } elseif (isset($tag['name'])) {
                $tagValue = $tag['name'];
            } else {
                $tagValue = implode(' ', $tag);
            }
        } elseif (is_string($tag)) {
            $tagValue = $tag;
        } else {
            $tagValue = (string)$tag;
        }
        
        // Clean up the tag value
        $tagValue = trim($tagValue);
        $tagValue = preg_replace('/^[\[\{"]+|[\]\}"]+$/', '', $tagValue); // Remove brackets and quotes
        $tagValue = preg_replace('/^value["\s]*[:=]\s*/i', '', $tagValue); // Remove "value:" prefix
        $tagValue = trim($tagValue);
        
        return $tagValue;
    }
}
