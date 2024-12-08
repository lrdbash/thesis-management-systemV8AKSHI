<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Support\Facades\Auth;
use App\Models\Intake;
use App\Models\Users;
class EventController extends Controller
{
    public function fetchEvents()
    {
        $events = Event::all();

        // Format events for FullCalendar
        $formattedEvents = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'date' => $event->date,
                'id' => $event->id,
            ];
        });

        return response()->json($formattedEvents);
    }

    public function fetchEvents1()
    {
        // Fetch the currently authenticated user
$user = auth()->user();

// Get intake IDs associated with the user
$intakeIds = $user->intakes->pluck('id');

// Fetch events that match the user's intake IDs
$events = Event::whereIn('intakeid', $intakeIds)->get();


        // Format events for FullCalendar
        $formattedEvents = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'date' => $event->date,
                'id' => $event->id,
            ];
        });

        return response()->json($formattedEvents);
    }

    public function store(Request $request)
{
    $event = new Event;
    $event->title = $request->title;
    $event->intakeid = $request->intakeid;
    $event->date = $request->date;
    $event->description ="";
    $event->save();

    return response()->json(['message' => 'Event created successfully']);
}

public function update(Request $request)
{
    $event = Event::find($request->id);
    if (!$event) {
        return response()->json(['message' => 'Event not found'], 404);
    }

    // Check if title needs to be updated
    if ($request->has('new_title')) {
        $event->title = $request->new_title;
    }

    // Check if date needs to be updated
    if ($request->has('new_date')) {
        $event->date = $request->new_date;
    }

    $event->save();

    return response()->json(['message' => 'Event updated successfully']);
}

public function destroy(Request $request)
{
    $event = Event::find($request->id);
    if ($event) {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }

    return response()->json(['message' => 'Event not found'], 404);
}


public function update1(Request $request)
{
    $event = Event::find($request->id);

    if ($event) {
        // Update the event's details
        //$event->title = $request->title; // Optional: if you want to update title as well
        $event->date = $request->new_date;
        $event->save();

        return response()->json(['message' => 'Event updated successfully!']);
    } else {
        return response()->json(['message' => 'Event not found'], 404);
    }
}

}
