<?php 

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use App\Models\Engineer;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    protected $client;
    protected $service;

    /**
     * Constructor
     *
     * Creates a new Google Client instance and sets the Calendar service
     * with read-only scope. The client is set to use the credentials
     * from the `app/google-credentials.json` file, and is configured to
     * use offline access and prompt for consent. The service is then
     * set to an instance of Google_Service_Calendar.
     */
    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName(config('google-calendar.application_name'));
        $this->client->setClientId(config('google-calendar.client_id'));
        $this->client->setClientSecret(config('google-calendar.client_secret'));
        $this->client->setRedirectUri(config('google-calendar.redirect_uri'));
        $this->client->setScopes(config('google-calendar.scopes'));
        $this->client->setAccessType(config('google-calendar.access_type'));
        $this->client->setPrompt(config('google-calendar.prompt'));

        $this->service = new Google_Service_Calendar($this->client);
    }

    /**
     * Syncs the holidays for a given engineer from their Google Calendar.
     *
     * The method will only run if the engineer has a calendar ID set.
     * It will then query the Google Calendar API for events in the
     * next year, and for each event, it will update or create a
     * corresponding `Holiday` model in the database.
     *
     * If an exception occurs during the process, it will be logged
     * and re-thrown.
     *
     * @param Engineer $engineer The engineer to sync holidays for
     * @param callable|null $progressCallback A callback function to track progress
     *
     * @throws \Exception
     */
    public function syncEngineerHolidays(Engineer $engineer, ?callable $progressCallback = null)
    {
        if (!$engineer->calendar_id) {
            return;
        }

        try {
            $optParams = [
                'maxResults' => 100,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => Carbon::now()->startOfDay()->toRfc3339String(),
                'timeMax' => Carbon::now()->addYear()->endOfDay()->toRfc3339String(),
            ];

            $results = $this->service->events->listEvents($engineer->calendar_id, $optParams);
            $events = $results->getItems();
            $totalEvents = count($events);
            $processedEvents = 0;

            if ($progressCallback) {
                $progressCallback(0, "Found {$totalEvents} events to process", $totalEvents, $processedEvents);
            }

            foreach ($events as $event) {
                $start = Carbon::parse($event->getStart()->getDateTime());
                $end = Carbon::parse($event->getEnd()->getDateTime());

                Holiday::updateOrCreate(
                    [
                        'engineer_id' => $engineer->id,
                        'start_date' => $start,
                        'end_date' => $end,
                    ],
                    [
                        'title' => $event->getSummary(),
                        'description' => $event->getDescription(),
                        'google_event_id' => $event->getId(),
                    ]
                );

                $processedEvents++;
                if ($progressCallback) {
                    $progress = ($processedEvents / $totalEvents) * 100;
                    $progressCallback(
                        round($progress, 2),
                        "Processing event {$processedEvents} of {$totalEvents}",
                        $totalEvents,
                        $processedEvents
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error('Error syncing engineer holidays: ' . $e->getMessage());
            throw $e;
        }
    }
}