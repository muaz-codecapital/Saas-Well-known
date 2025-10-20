<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workspace_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'color',
        'all_day',
        'google_event_id',
        'google_calendar_data',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'all_day' => 'boolean',
        'google_calendar_data' => 'array',
    ];

    /**
     * Get the user that owns the event.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the workspace that the event belongs to.
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * Check if the event is synced with Google Calendar.
     */
    public function isSyncedWithGoogle(): bool
    {
        return !is_null($this->google_event_id);
    }

    /**
     * Get the Google Calendar data for this event.
     */
    public function getGoogleCalendarData(): ?array
    {
        return $this->google_calendar_data;
    }

    /**
     * Scope to get events for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get events within a date range.
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate]);
    }

    /**
     * Scope to get only Google-synced events.
     */
    public function scopeSyncedWithGoogle($query)
    {
        return $query->whereNotNull('google_event_id');
    }
}
