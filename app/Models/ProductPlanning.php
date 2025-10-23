<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductPlanning extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'workspace_id',
        'title',
        'description',
        'status',
        'priority',
        'product_id',
        'department_id',
        'group_type',
        'group_id',
        'start_date',
        'due_date',
        'progress',
        'assigned_to',
        'estimated_hours',
        'actual_hours',
        'tags',
        'attachments',
        'dependencies',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'due_date' => 'datetime',
        'progress' => 'integer',
        'estimated_hours' => 'integer',
        'actual_hours' => 'integer',
        'tags' => 'array',
        'attachments' => 'array',
        'dependencies' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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
            if (empty($model->created_by)) {
                $model->created_by = auth()->id();
            }
            if (empty($model->status)) {
                $model->status = 'idea';
            }
        });

        static::updating(function ($model) {
            if (empty($model->updated_by)) {
                $model->updated_by = auth()->id();
            }
        });
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function group()
    {
        return $this->morphTo();
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

    public function scopeByWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?: auth()->user()->workspace_id;
        return $query->where('workspace_id', $workspaceId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByGroup($query, $groupType, $groupId)
    {
        return $query->where('group_type', $groupType)->where('group_id', $groupId);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['archived', 'cancelled']);
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'idea' => 'info',
            'validation' => 'warning',
            'in_development' => 'primary',
            'testing' => 'secondary',
            'released' => 'success',
            'archived' => 'dark'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'idea' => 'Idea',
            'validation' => 'Validation',
            'in_development' => 'In Development',
            'testing' => 'Testing',
            'released' => 'Released',
            'archived' => 'Archived'
        ];

        return $labels[$this->status] ?? ucfirst($this->status);
    }

    public function getPriorityLabelAttribute()
    {
        $labels = [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent'
        ];

        return $labels[$this->priority] ?? ucfirst($this->priority);
    }

    public function getPriorityColorAttribute()
    {
        $colors = [
            'low' => 'secondary',
            'medium' => 'info',
            'high' => 'warning',
            'urgent' => 'danger'
        ];

        return $colors[$this->priority] ?? 'secondary';
    }
}
