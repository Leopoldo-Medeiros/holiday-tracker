<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Calendar Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration settings for Google Calendar integration.
    | All sensitive credentials are stored in the .env file.
    |
    */

    'client_id' => env('GOOGLE_CALENDAR_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CALENDAR_CLIENT_SECRET'),
    'redirect_uri' => env('GOOGLE_CALENDAR_REDIRECT_URI'),
    'application_name' => env('GOOGLE_CALENDAR_APPLICATION_NAME', 'Holiday Tracker'),
    
    'scopes' => [
        'https://www.googleapis.com/auth/calendar.readonly',
    ],

    'access_type' => 'offline',
    'prompt' => 'select_account consent',
];