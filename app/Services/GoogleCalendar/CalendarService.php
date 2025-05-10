<?php

namespace App\Services\GoogleCalendar;

use App\Models\Engineer;
use App\Models\Holiday;
use App\Services\GoogleCalendar\Google_Client;
use App\Services\GoogleCalendar\Google_Service_Calendar as Calendar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class CalendarService
{
    private Google_Client $client;
    private Calendar $service;

    /**
     * CalendarService constructor.
     *
     * Create a new Google Calendar client, and set the Calendar service with read-only scope.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(config('services.google.credentials_path'));
        $this->client->addScope('https://www.googleapis.com/auth/calendar.readonly');

        $this->service = new Calendar($this->client);
    }

    /**
     * Get the engineer's calendar events.
     *
     * @param Engineer $engineer
     * @return Collection
     */

    /**
     * Set up a push notification channel for a given calendar.
     *
     * When a calendar event is created, modified or deleted, the Google Calendar
     * service will send a notification to the webhook URL specified in the
     * configuration file.
     *
     * @param string $calendarId The ID of the calendar to watch.
     * @return void
     * @throws \Throwable
     */
    public function watchCalendar(string $calendarId): void
    {
        try {
            $channel = new Google_Service_Calendar_Channel([
                'id' => uniqid(),
                'type' => 'web_hook',
                'address' => config('services.google.webhook_url')
            ]);

            $this->service->getEvents()->watch($calendarId, $channel);
        } catch (\Throwable $e) {
            Log::error('Failed to watch calendar', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

     /**
     * Process a Google Calendar event as a holiday.
     *
     * Takes a Google Calendar event array, and creates a new Holiday model.
     *
     * @param array $eventData
     * @return Holiday|null
     */
     public function processHolidayEvent(array $eventData): ?Holiday
     {
        $engineerEmail = $eventData['creator']['email'];

        $engineer = Engineer::where('email', $engineerEmail)->first();

        if(!$engineer) {
            return null;
        }

        return Holiday::create([
            'engineer_id' => $engineer->id,
            'start_date' => $eventData['start']['dateTime'],
            'end_date' => $eventData['end']['dateTime'],
            'status' => 'pending',
            'calendar_event_id' => $eventData['id']
        ]);
     }
}
