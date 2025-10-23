<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Workspace;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'workspace_id',
        'name',
        'description',
        'website',
        'industry',
        'company_size',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'phone',
        'email',
        'social_links',
        'annual_revenue',
        'currency',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'social_links' => 'array',
        'annual_revenue' => 'decimal:2',
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

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function leads()
    {
        return $this->hasMany(Contact::class)->where('type', 'lead');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
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

    public function scopeByIndustry($query, $industry)
    {
        return $query->where('industry', $industry);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('website', 'like', "%{$search}%");
        });
    }
}
