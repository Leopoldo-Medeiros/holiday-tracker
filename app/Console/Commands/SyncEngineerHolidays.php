<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Engineer;
use App\Services\GoogleCalendarService;

class SyncEngineerHolidays extends Command
{
    protected $signature = 'engineers:sync-holidays';
    protected $description = 'Sync holidays for all engineers from their Google Calendars';

    protected $calendarService;

    public function __construct(GoogleCalendarService $calendarService)
    {
        parent::__construct();
        $this->calendarService = $calendarService;
    }

    public function handle()
    {
        $engineers = Engineer::whereNotNull('calendar_id')->get();
        
        $this->info("Starting holiday sync for {$engineers->count()} engineers...");
        
        $bar = $this->output->createProgressBar($engineers->count());
        $bar->start();

        foreach ($engineers as $engineer) {
            try {
                $this->calendarService->syncEngineerHolidays($engineer);
                $bar->advance();
            } catch (\Exception $e) {
                $this->error("\nFailed to sync holidays for engineer {$engineer->name}: {$e->getMessage()}");
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info('Holiday sync completed!');
    }
}