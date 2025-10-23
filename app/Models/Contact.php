<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\User;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'workspace_id',
        'company_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'job_title',
        'department',
        'type',
        'status',
        'source',
        'notes',
        'social_links',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'lead_value',
        'expected_close_date',
        'priority',
        'assigned_to',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'social_links' => 'array',
        'lead_value' => 'decimal:2',
        'expected_close_date' => 'date',
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
        });
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'contact_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusLabelAttribute()
    {
        $statuses = config('crm.pipeline_statuses');
        return $statuses[$this->status]['label'] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute()
    {
        $statuses = config('crm.pipeline_statuses');
        return $statuses[$this->status]['color'] ?? '#8392ab';
    }

    public function getStatusIconAttribute()
    {
        $statuses = config('crm.pipeline_statuses');
        return $statuses[$this->status]['icon'] ?? 'circle';
    }

    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }

    public function getSourceLabelAttribute()
    {
        $sources = config('crm.lead_sources');
        return $sources[$this->source]['label'] ?? ucfirst(str_replace('_', ' ', $this->source));
    }

    public function getPriorityLabelAttribute()
    {
        $priorities = config('crm.priorities');
        return $priorities[$this->priority]['label'] ?? 'Medium';
    }

    public function getPriorityColorAttribute()
    {
        $priorities = config('crm.priorities');
        return $priorities[$this->priority]['color'] ?? '#17c1e8';
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

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByAssignedUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('company_name', 'like', "%{$search}%");
        });
    }

    public function scopeLeads($query)
    {
        return $query->where('type', 'lead');
    }

    public function scopeContacts($query)
    {
        return $query->where('type', 'contact');
    }
}
