<?php

namespace App\Services;

use App\Models\Event;
use App\Models\GoogleAccount;
use App\Models\User;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event as GoogleEvent;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    protected Client $client;

    public function __construct()
    {
        try {
            $this->client = new Client();
            $this->client->setApplicationName(config('app.name'));

            // Get Google credentials from config or env
            $clientId = config('services.google.client_id') ?: env('GOOGLE_CLIENT_ID');
            $clientSecret = config('services.google.client_secret') ?: env('GOOGLE_CLIENT_SECRET');
            $redirectUri = config('services.google.redirect_uri') ?: env('GOOGLE_REDIRECT_URI', rtrim(env('APP_URL'), '/') . '/google/callback');

            // Debug logging (can be removed in production)
            // Log::info('Google credentials check', [
            //     'client_id_exists' => !empty($clientId),
            //     'client_secret_exists' => !empty($clientSecret),
            //     'redirect_uri' => $redirectUri,
            //     'app_url' => env('APP_URL')
            // ]);

            if (!$clientId || !$clientSecret) {
                throw new \Exception('Google OAuth credentials not configured. Please set GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in your .env file.');
            }

            $this->client->setClientId($clientId);
            $this->client->setClientSecret($clientSecret);
            $this->client->setRedirectUri($redirectUri);

            // Set scopes as array, not from env string
            $this->client->setScopes([
                'https://www.googleapis.com/auth/calendar',
                'https://www.googleapis.com/auth/calendar.events',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile'
            ]);
            $this->client->setAccessType('offline');
            $this->client->setPrompt('consent');

            // Log configuration for debugging (can be removed in production)
            // Log::info('Google Client configured successfully', [
            //     'client_id' => substr($clientId, 0, 10) . '...',
            //     'redirect_uri' => $redirectUri,
            //     'scopes' => $this->client->getScopes()
            // ]);
        } catch (\Exception $e) {
            Log::error('Failed to initialize Google Client: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get authenticated Google client for a user.
     */
    public function getClient(?User $user = null): Client
    {
        $client = clone $this->client;

        if ($user && $googleAccount = $user->googleAccount) {
            $client->setAccessToken([
                'access_token' => $googleAccount->access_token,
                'refresh_token' => $googleAccount->refresh_token,
                'expires_in' => $googleAccount->expires_in,
                'created' => $googleAccount->token_created_at?->timestamp ?? 0,
            ]);

            // Refresh token if expired
            if ($client->isAccessTokenExpired()) {
                $this->refreshAccessToken($client, $googleAccount);
            }
        }

        return $client;
    }

    /**
     * Refresh the access token for a Google account.
     */
    protected function refreshAccessToken(Client $client, GoogleAccount $googleAccount): void
    {
        try {
            if (!$googleAccount->refresh_token) {
                throw new \Exception('No refresh token available');
            }

            $client->refreshToken($googleAccount->refresh_token);

            $newToken = $client->getAccessToken();

            if ($newToken && isset($newToken['access_token'])) {
                $googleAccount->updateToken(
                    $newToken['access_token'],
                    $newToken['refresh_token'] ?? $googleAccount->refresh_token,
                    $newToken['expires_in'] ?? 3600
                );

                Log::info("Google access token refreshed for user {$googleAccount->user_id}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to refresh Google access token for user {$googleAccount->user_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sync events from Google Calendar to local database.
     */
    public function syncFromGoogle(User $user): int
    {
        try {
            $googleAccount = $user->googleAccount;

            if (!$googleAccount || !$googleAccount->is_connected) {
                throw new \Exception('Google account not connected');
            }

            $client = $this->getClient($user);
            $calendarService = new Calendar($client);

            // Get user's timezone from their primary calendar (dynamic - always current)
            $calendar = $calendarService->calendars->get('primary');
            $userTimezone = $calendar->getTimeZone() ?: 'UTC';
            
            Log::info("Using user timezone: {$userTimezone} for user {$user->id}");

            // Get events from Google Calendar (last 30 days to next 6 months)
            $startDateTime = now()->subDays(30)->toRfc3339String();
            $endDateTime = now()->addMonths(6)->toRfc3339String();


            $eventsList = $calendarService->events->listEvents('primary', [
                'timeMin' => $startDateTime,
                'timeMax' => $endDateTime,
                'singleEvents' => true,
                'orderBy' => 'startTime',
            ]);

            $newEventsCount = 0;
            $totalEventsProcessed = 0;

            foreach ($eventsList->getItems() as $googleEvent) {
                $wasNew = $this->syncGoogleEventToLocal($googleEvent, $user, $userTimezone);
                $totalEventsProcessed++;
                if ($wasNew) {
                    $newEventsCount++;
                }
            }

            Log::info("Processed {$totalEventsProcessed} events, {$newEventsCount} new events synced from Google Calendar for user {$user->id}");

            return $newEventsCount;
        } catch (\Exception $e) {
            Log::error("Failed to sync from Google Calendar for user {$user->id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sync a single Google event to local database.
     * Returns true if the event was newly created, false if it was updated.
     */
    protected function syncGoogleEventToLocal(GoogleEvent $googleEvent, User $user, string $userTimezone = 'UTC'): bool
    {
        $startDateTime = $googleEvent->getStart();
        $endDateTime = $googleEvent->getEnd();

        // Handle all-day events (multi-day events)
        $isAllDay = $startDateTime->getDate() && $endDateTime->getDate();
        
        // Determine start and end times with proper timezone handling
        if ($isAllDay) {
            // For all-day events, use the date directly
            $startTime = $startDateTime->getDate();
            $endTime = $endDateTime->getDate();
            
            // Convert to Carbon instances for proper handling
            $startTime = \Carbon\Carbon::parse($startTime)->startOfDay();
            // For all-day events, Google uses exclusive end dates, so subtract 1 day
            $endTime = \Carbon\Carbon::parse($endTime)->startOfDay()->subDay();
        } else {
            // For timed events, use datetime with user's timezone conversion
            $startTime = $startDateTime->getDateTime() ?: $startDateTime->getDate();
            $endTime = $endDateTime->getDateTime() ?: $endDateTime->getDate();
            
            // Convert to Carbon instances and handle user's timezone
            if ($startTime) {
                $startTime = \Carbon\Carbon::parse($startTime)->setTimezone($userTimezone);
            }
            if ($endTime) {
                $endTime = \Carbon\Carbon::parse($endTime)->setTimezone($userTimezone);
            }
        }

        // Check if event already exists
        $existingEvent = Event::where('google_event_id', $googleEvent->getId())
            ->where('user_id', $user->id)
            ->first();
        
        $wasNew = !$existingEvent;

        $localEvent = Event::updateOrCreate(
            [
                'google_event_id' => $googleEvent->getId(),
                'user_id' => $user->id,
            ],
            [
                'workspace_id' => $user->workspace_id,
                'title' => $googleEvent->getSummary() ?: 'Untitled Event',
                'description' => $googleEvent->getDescription() ?: '',
                'start_date' => $startTime,
                'end_date' => $endTime,
                'color' => $this->getColorFromGoogleEvent($googleEvent),
                'all_day' => $isAllDay,
                'google_calendar_data' => [
                    'etag' => $googleEvent->getEtag(),
                    'status' => $googleEvent->getStatus(),
                    'location' => $googleEvent->getLocation(),
                    'attendees' => $this->formatAttendees($googleEvent->getAttendees()),
                ],
            ]
        );

        Log::debug("Synced Google event {$googleEvent->getId()} to local event {$localEvent->id} (was new: " . ($wasNew ? 'yes' : 'no') . ")");
        
        return $wasNew;
    }

    /**
     * Sync local event to Google Calendar (create/update/delete).
     */
    public function syncToGoogle(User $user, Event $event): void
    {
        try {
            $googleAccount = $user->googleAccount;

            if (!$googleAccount || !$googleAccount->is_connected) {
                return; // Skip if not connected
            }

            $client = $this->getClient($user);
            $calendarService = new Calendar($client);

            $googleEvent = $this->createGoogleEventFromLocal($event);

            if ($event->google_event_id) {
                // Update existing Google event
                $calendarService->events->update('primary', $event->google_event_id, $googleEvent);
                Log::debug("Updated Google event {$event->google_event_id} for local event {$event->id}");
            } else {
                // Create new Google event
                $createdEvent = $calendarService->events->insert('primary', $googleEvent);
                $event->update(['google_event_id' => $createdEvent->getId()]);
                Log::debug("Created Google event {$createdEvent->getId()} for local event {$event->id}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to sync local event {$event->id} to Google Calendar: " . $e->getMessage());
            // Don't throw exception to avoid breaking the main event creation flow
        }
    }

    /**
     * Create a Google Event object from a local Event.
     */
    protected function createGoogleEventFromLocal(Event $event): GoogleEvent
    {
        $googleEvent = new GoogleEvent();
        $googleEvent->setSummary($event->title);
        $googleEvent->setDescription($event->description);

        // Set start and end times
        $start = new \Google\Service\Calendar\EventDateTime();
        $end = new \Google\Service\Calendar\EventDateTime();

        if ($event->all_day) {
            $start->setDate($event->start_date->format('Y-m-d'));
            // For all-day events, add 1 day to end date to match Google's exclusive end date format
            $end->setDate($event->end_date->addDay()->format('Y-m-d'));
        } else {
            $start->setDateTime($event->start_date->toRfc3339String());
            $end->setDateTime($event->end_date->toRfc3339String());
        }

        $googleEvent->setStart($start);
        $googleEvent->setEnd($end);

        // Set color if available
        if ($event->color) {
            $googleEvent->setColorId($this->getGoogleColorId($event->color));
        }

        return $googleEvent;
    }

    /**
     * Get Google color ID from hex color.
     */
    protected function getGoogleColorId(string $hexColor): ?string
    {
        // Google Calendar color mapping (simplified)
        $colorMap = [
            '#ff0000' => '1', // Red
            '#ff9900' => '2', // Orange
            '#ffff00' => '3', // Yellow
            '#00ff00' => '4', // Green
            '#0099ff' => '5', // Blue
            '#9900ff' => '6', // Purple
            '#ff00ff' => '7', // Pink
        ];

        return $colorMap[strtolower($hexColor)] ?? null;
    }

    /**
     * Get color from Google event.
     */
    protected function getColorFromGoogleEvent(GoogleEvent $googleEvent): ?string
    {
        $colorId = $googleEvent->getColorId();

        if (!$colorId) {
            return null;
        }

        // Map Google color IDs back to hex colors
        $colorMap = [
            '1' => '#ff0000', // Red
            '2' => '#ff9900', // Orange
            '3' => '#ffff00', // Yellow
            '4' => '#00ff00', // Green
            '5' => '#0099ff', // Blue
            '6' => '#9900ff', // Purple
            '7' => '#ff00ff', // Pink
        ];

        return $colorMap[$colorId] ?? null;
    }

    /**
     * Format Google event attendees for local storage.
     */
    protected function formatAttendees(?array $attendees): array
    {
        if (!$attendees) {
            return [];
        }

        return array_map(function ($attendee) {
            return [
                'email' => $attendee->getEmail(),
                'displayName' => $attendee->getDisplayName(),
                'responseStatus' => $attendee->getResponseStatus(),
            ];
        }, $attendees);
    }

    /**
     * Delete event from Google Calendar.
     */
    public function deleteFromGoogle(User $user, string $googleEventId): void
    {
        try {
            $googleAccount = $user->googleAccount;

            if (!$googleAccount || !$googleAccount->is_connected) {
                return;
            }

            $client = $this->getClient($user);
            $calendarService = new Calendar($client);

            $calendarService->events->delete('primary', $googleEventId);

            Log::debug("Deleted Google event {$googleEventId} for user {$user->id}");
        } catch (\Exception $e) {
            Log::error("Failed to delete Google event {$googleEventId}: " . $e->getMessage());
        }
    }
}

