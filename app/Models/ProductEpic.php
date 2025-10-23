<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductEpic extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'workspace_id',
        'product_id',
        'title',
        'description',
        'status',
        'priority',
        'created_by',
        'updated_by'
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
                $model->status = 'planned';
            }
            if (empty($model->priority)) {
                $model->priority = 'medium';
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function productPlannings()
    {
        return $this->hasMany(ProductPlanning::class, 'group_id')->where('group_type', 'epic');
    }

    public function scopeByWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?: auth()->user()->workspace_id;
        return $query->where('workspace_id', $workspaceId);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled']);
    }
}
