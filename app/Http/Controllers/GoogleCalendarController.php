<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client as Google_Client;
use Google\Service\Calendar as Google_Service_Calendar;
use Google\Service\Calendar\Event as Google_Service_Calendar_Event;
use Google\Service\Calendar\EventDateTime as Google_Service_Calendar_EventDateTime;


class GoogleCalendarController extends Controller
{
    public function login()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Google_Service_Calendar::CALENDAR);
        
        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->input('code'));
            session(['google_token' => $token]);
            return redirect('/'); // Redirect back to your main page after authentication
        }

        return response()->json('Something went wrong');
    }

    // Function to sync events from your calendar to Google Calendar
    public function syncToGoogle(Request $request)
    {
        $client = new Google_Client();
        $client->setAccessToken(session('google_token'));

        if ($client->isAccessTokenExpired()) {
            return redirect('/google-login'); // Redirect to login if token is expired
        }

        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary'; // Default calendar

        // Example event to sync with Google Calendar
        $event = new Google_Service_Calendar_Event([
            'summary' => $request->input('title'), // Title from request
            'start' => new Google_Service_Calendar_EventDateTime([
                'dateTime' => $request->input('start_date'),
                'timeZone' => 'UTC',
            ]),
            'end' => new Google_Service_Calendar_EventDateTime([
                'dateTime' => $request->input('end_date'),
                'timeZone' => 'UTC',
            ]),
        ]);

        $service->events->insert($calendarId, $event);

        return response()->json(['message' => 'Event synced to Google Calendar successfully']);
    }

    // Function to sync events from Google Calendar to your local database
    public function syncFromGoogle()
    {
        $client = new Google_Client();
        $client->setAccessToken(session('google_token'));

        if ($client->isAccessTokenExpired()) {
            return redirect('/google-login');
        }

        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary'; // Default Google Calendar

        $events = $service->events->listEvents($calendarId);
        foreach ($events->getItems() as $event) {
            // You can save events to your local database here
            Event::updateOrCreate(
                ['google_event_id' => $event->getId()], // Unique identifier for Google Calendar event
                [
                    'title' => $event->getSummary(),
                    'start_date' => $event->getStart()->getDateTime(),
                    'end_date' => $event->getEnd()->getDateTime(),
                ]
            );
        }

        return response()->json(['message' => 'Events synced from Google Calendar successfully']);
    }
}
