<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'workspace_id',
        'admin_id',
        'owner_id',
        'assignee_id',
        'contact_id',
        'ticket_id',
        'deal_id',
        'priority_id',
        'status',
        'priority',
        'subject',
        'description',
        'due_date',
        'start_date',
        'group',
        'workspace_type',
        'estimated_hours',
        'actual_hours',
        'progress',
        'tags'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'due_date' => 'datetime',
        'progress' => 'integer',
        'estimated_hours' => 'integer',
        'actual_hours' => 'integer',
        'tags' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
            if (empty($model->workspace_id)) {
                $model->workspace_id = auth()->user()->workspace_id;
            }
            if (empty($model->status)) {
                $model->status = 'to_do';
            }
            if (empty($model->priority)) {
                $model->priority = 'medium';
            }
        });
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function contact()
    {
        return $this->belongsTo(User::class, 'contact_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getStatusLabelAttribute()
    {
        $statuses = config('task.statuses');
        return $statuses[$this->status]['label'] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute()
    {
        $statuses = config('task.statuses');
        return $statuses[$this->status]['class'] ?? 'secondary';
    }

    public function getStatusIconAttribute()
    {
        $statuses = config('task.statuses');
        return $statuses[$this->status]['icon'] ?? 'circle';
    }

    public function getPriorityLabelAttribute()
    {
        $priorities = config('task.priorities');
        return $priorities[$this->priority]['label'] ?? ucfirst($this->priority);
    }

    public function getPriorityColorAttribute()
    {
        $priorities = config('task.priorities');
        return $priorities[$this->priority]['class'] ?? 'secondary';
    }

    public function getPriorityClassAttribute()
    {
        $priorities = config('task.priorities');
        return $priorities[$this->priority]['class'] ?? 'secondary';
    }

    public function getWorkspaceTypeLabelAttribute()
    {
        $workspaceTypes = config('task.workspace_types');
        return $workspaceTypes[$this->workspace_type]['label'] ?? ucfirst(str_replace('_', ' ', $this->workspace_type));
    }

    public function getWorkspaceTypeIconAttribute()
    {
        $workspaceTypes = config('task.workspace_types');
        return $workspaceTypes[$this->workspace_type]['icon'] ?? 'folder';
    }

    public function getWorkspaceTypeColorAttribute()
    {
        $workspaceTypes = config('task.workspace_types');
        return $workspaceTypes[$this->workspace_type]['color'] ?? '#6c757d';
    }

    public function scopeByWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?: auth()->user()->workspace_id;
        return $query->where('workspace_id', $workspaceId);
    }

    public function scopeByWorkspaceType($query, $workspaceType)
    {
        return $query->where('workspace_type', $workspaceType);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}
