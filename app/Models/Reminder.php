<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\User;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'workspace_id',
        'contact_id',
        'company_id',
        'task_id',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'type',
        'remind_at',
        'status',
        'priority',
        'completed_at',
        'completion_notes',
        'is_recurring',
        'recurrence_type',
        'recurrence_interval',
        'next_reminder_at'
    ];

    protected $casts = [
        'remind_at' => 'datetime',
        'completed_at' => 'datetime',
        'next_reminder_at' => 'datetime',
        'is_recurring' => 'boolean',
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
                $model->status = 'pending';
            }
        });

        static::updating(function ($model) {
            // If reminder is being marked as completed, set completed_at
            if ($model->isDirty('status') && $model->status === 'completed' && empty($model->completed_at)) {
                $model->completed_at = now();
            }

            // Handle recurring reminders
            if ($model->isDirty('status') && $model->status === 'completed' && $model->is_recurring) {
                $this->createNextRecurringReminder($model);
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

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getTypeLabelAttribute()
    {
        $types = config('crm.activity_types');
        return $types[$this->type]['label'] ?? ucfirst(str_replace('_', ' ', $this->type));
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
            'pending' => 'Pending',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'overdue' => 'Overdue'
        ];
        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => '#17c1e8',
            'completed' => '#11998e',
            'cancelled' => '#8392ab',
            'overdue' => '#ea0606'
        ];
        return $colors[$this->status] ?? '#8392ab';
    }

    public function getPriorityLabelAttribute()
    {
        $priorities = config('crm.priorities');
        return $priorities[$this->priority]['label'] ?? ucfirst($this->priority);
    }

    public function getPriorityColorAttribute()
    {
        $priorities = config('crm.priorities');
        return $priorities[$this->priority]['color'] ?? '#17c1e8';
    }

    public function getRecurrenceLabelAttribute()
    {
        if (!$this->is_recurring) {
            return null;
        }

        $interval = $this->recurrence_interval > 1 ? $this->recurrence_interval . ' ' : '';
        $type = ucfirst(str_replace('_', ' ', $this->recurrence_type));

        return "Every {$interval}{$type}";
    }

    public function isOverdue()
    {
        return $this->status === 'pending' && $this->remind_at < now();
    }

    public function isUpcoming()
    {
        return $this->status === 'pending' && $this->remind_at > now();
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByAssignedUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeByContact($query, $contactId)
    {
        return $query->where('contact_id', $contactId);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                     ->where('remind_at', '<', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'pending')
                     ->where('remind_at', '>', now())
                     ->orderBy('remind_at');
    }

    public function scopeDueToday($query)
    {
        return $query->where('status', 'pending')
                     ->whereDate('remind_at', today());
    }

    public function scopeDueThisWeek($query)
    {
        return $query->where('status', 'pending')
                     ->whereBetween('remind_at', [now(), now()->addWeek()]);
    }

    private function createNextRecurringReminder($model)
    {
        if (!$model->is_recurring || empty($model->recurrence_type) || empty($model->recurrence_interval)) {
            return;
        }

        $nextReminderAt = $this->calculateNextReminderDate($model->completed_at ?: $model->remind_at, $model->recurrence_type, $model->recurrence_interval);

        if ($nextReminderAt) {
            self::create([
                'workspace_id' => $model->workspace_id,
                'contact_id' => $model->contact_id,
                'company_id' => $model->company_id,
                'task_id' => $model->task_id,
                'created_by' => $model->created_by,
                'assigned_to' => $model->assigned_to,
                'title' => $model->title,
                'description' => $model->description,
                'type' => $model->type,
                'remind_at' => $nextReminderAt,
                'status' => 'pending',
                'priority' => $model->priority,
                'is_recurring' => true,
                'recurrence_type' => $model->recurrence_type,
                'recurrence_interval' => $model->recurrence_interval,
                'next_reminder_at' => $this->calculateNextReminderDate($nextReminderAt, $model->recurrence_type, $model->recurrence_interval),
            ]);
        }
    }

    private function calculateNextReminderDate($fromDate, $recurrenceType, $interval)
    {
        switch ($recurrenceType) {
            case 'daily':
                return $fromDate->addDays($interval);
            case 'weekly':
                return $fromDate->addWeeks($interval);
            case 'monthly':
                return $fromDate->addMonths($interval);
            case 'yearly':
                return $fromDate->addYears($interval);
            default:
                return null;
        }
    }
}
