<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Intake; // Import the Intake model

class IntakeController extends Controller
{
    // Method to list all intakes and automatically close those open for more than 14 days
    public function index()
    {
        // Automatically close intakes that have been open for more than 14 days
        Intake::where('status', 'open')
            ->where('created_at', '<=', now()->subDays(14))
            ->update(['status' => 'closed']);

        // Retrieve all intakes
        $intakes = Intake::all();

        // Decode chapters JSON for each intake before passing to the view
        foreach ($intakes as $intake) {
            $intake->chapters = json_decode($intake->chapters, true);
        }

        return view('admin.intakes.index', compact('intakes'));
    }

    // Method to show the form for creating an intake
    public function create()
    {
        return view('admin.intakes.create');
    }

    // Method to toggle the status of an intake
    public function toggleStatus($id)
    {
        $intake = Intake::findOrFail($id);
        $intake->status = $intake->status === 'open' ? 'closed' : 'open';
        $intake->save();

        return redirect()->route('admin.intakes.list')->with('success', 'Intake status updated successfully.');
    }

    // Method to store intake data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'chapters' => 'required|array', // Validate chapters as an array
            'chapters.*.name' => 'required|string|max:255', // Each chapter must have a name
            'chapters.*.deadline' => 'required|date', // Each chapter must have a deadline
            'final_submission_deadline' => 'required|date',
            'presentation_date' => 'required|date',
        ]);

        // Store the intake with chapters as a JSON string
        Intake::create([
            'name' => $request->name,
            'chapters' => json_encode($request->chapters), // Encode the chapters array as JSON before storing
            'final_submission_deadline' => $request->final_submission_deadline,
            'presentation_date' => $request->presentation_date,
            'status' => 'open', // Default status
        ]);

        return redirect()->route('admin.intakes.list')->with('success', 'Intake created successfully.');
    }

    // Method to fetch events for a user (used in calendar or other features)
    public function fetchEvents()
    {
        $user = auth()->user();

        if ($user->role === 'student') {
            $intakes = $user->intakes->pluck('id'); // Get intake IDs for the student
            $events = Event::whereIn('intake_id', $intakes)->get(); // Filter events by intake
        } else {
            $events = Event::all(); // Admin or other roles can view all events
        }

        return response()->json($events);
    }
}
