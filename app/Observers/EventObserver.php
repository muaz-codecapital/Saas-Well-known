<?php

namespace App\Observers;

use App\Models\Event;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Log;

class EventObserver
{
    protected GoogleCalendarService $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }

    /**
     * Handle the Event "created" event.
     * Sync to Google Calendar if user has connected account.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function created(Event $event)
    {
        try {
            if ($event->user && $event->user->googleAccount && $event->user->googleAccount->is_connected) {
                $this->googleCalendarService->syncToGoogle($event->user, $event);
            }
        } catch (\Exception $e) {
            Log::error("Failed to sync created event {$event->id} to Google Calendar: " . $e->getMessage());
        }
    }

    /**
     * Handle the Event "updated" event.
     * Sync to Google Calendar if user has connected account and event is synced.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        try {
            if ($event->user && $event->user->googleAccount && $event->user->googleAccount->is_connected) {
                // Only sync if this event is already synced with Google or if it's a new sync
                if ($event->isSyncedWithGoogle() || $event->user->googleAccount->is_connected) {
                    $this->googleCalendarService->syncToGoogle($event->user, $event);
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to sync updated event {$event->id} to Google Calendar: " . $e->getMessage());
        }
    }

    /**
     * Handle the Event "deleted" event.
     * Delete from Google Calendar if event was synced.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        try {
            if ($event->user && $event->google_event_id) {
                $this->googleCalendarService->deleteFromGoogle($event->user, $event->google_event_id);
            }
        } catch (\Exception $e) {
            Log::error("Failed to delete event {$event->id} from Google Calendar: " . $e->getMessage());
        }
    }

    /**
     * Handle the Event "restored" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function restored(Event $event)
    {
        // Handle restored events if needed
    }

    /**
     * Handle the Event "force deleted" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        // Handle force deleted events if needed
    }
}
