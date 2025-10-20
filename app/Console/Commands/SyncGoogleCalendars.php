<?php

namespace App\Console\Commands;

use App\Models\GoogleAccount;
use App\Services\GoogleCalendarService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncGoogleCalendars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:sync-calendars {--user_id= : Sync for specific user only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Google Calendar events for all users or a specific user';

    protected GoogleCalendarService $googleCalendarService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        parent::__construct();
        $this->googleCalendarService = $googleCalendarService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting Google Calendar sync...');

        try {
            $query = GoogleAccount::where('is_connected', true);

            // If specific user ID is provided, sync only that user
            if ($this->option('user_id')) {
                $userId = $this->option('user_id');
                $query->where('user_id', $userId);
                $this->info("Syncing Google Calendar for user ID: {$userId}");
            } else {
                $this->info('Syncing Google Calendar for all connected users...');
            }

            $googleAccounts = $query->get();
            $totalSynced = 0;
            $totalUsers = $googleAccounts->count();

            if ($totalUsers === 0) {
                $this->warn('No connected Google accounts found.');
                return 0;
            }

            $this->output->progressStart($totalUsers);

            foreach ($googleAccounts as $googleAccount) {
                try {
                    $syncedCount = $this->googleCalendarService->syncFromGoogle($googleAccount->user);
                    $totalSynced += $syncedCount;

                    $this->output->progressAdvance();

                    Log::info("Synced {$syncedCount} events from Google Calendar for user {$googleAccount->user_id}");
                } catch (\Exception $e) {
                    $this->error("Failed to sync Google Calendar for user {$googleAccount->user_id}: " . $e->getMessage());
                    Log::error("Google Calendar sync failed for user {$googleAccount->user_id}: " . $e->getMessage());
                    $this->output->progressAdvance();
                }
            }

            $this->output->progressFinish();

            $this->info("Google Calendar sync completed! Synced {$totalSynced} events for {$totalUsers} users.");

            return 0;
        } catch (\Exception $e) {
            $this->error('Google Calendar sync failed: ' . $e->getMessage());
            Log::error('Google Calendar sync command failed: ' . $e->getMessage());

            return 1;
        }
    }
}
