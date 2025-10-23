<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\User;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'workspace_id',
        'contact_id',
        'company_id',
        'task_id',
        'created_by',
        'type',
        'subject',
        'description',
        'notes',
        'status',
        'scheduled_at',
        'completed_at',
        'duration_minutes',
        'location',
        'attachments',
        'metadata'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'attachments' => 'array',
        'metadata' => 'array',
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
            if (empty($model->completed_at) && $model->status === 'completed') {
                $model->completed_at = now();
            }
        });
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTypeLabelAttribute()
    {
        $types = config('crm.activity_types');
        return $types[$this->type]['label'] ?? ucfirst($this->type);
    }

    public function getTypeIconAttribute()
    {
        $types = config('crm.activity_types');
        return $types[$this->type]['icon'] ?? 'circle';
    }

    public function getTypeColorAttribute()
    {
        $types = config('crm.activity_types');
        return $types[$this->type]['color'] ?? '#8392ab';
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'completed' => 'Completed',
            'scheduled' => 'Scheduled',
            'cancelled' => 'Cancelled',
            'no_show' => 'No Show'
        ];
        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    public function getDurationLabelAttribute()
    {
        if (!$this->duration_minutes) {
            return null;
        }

        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0) {
            return $hours . 'h ' . ($minutes > 0 ? $minutes . 'm' : '');
        }

        return $minutes . 'm';
    }

    public function scopeByWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?: auth()->user()->workspace_id;
        return $query->where('workspace_id', $workspaceId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByContact($query, $contactId)
    {
        return $query->where('contact_id', $contactId);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
                     ->where('scheduled_at', '>', now());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())
                     ->orderBy('scheduled_at');
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
                     ->orderBy('created_at', 'desc');
    }
}
