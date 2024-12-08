<?php

namespace App\Http\Controllers;

use App\Models\Examiner;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExaminerController extends Controller
{
    // Constructor to apply the role middleware
    public function __construct()
    {
        $this->middleware('role:admin')->except(['examinerDashboard', 'uploadCv']); // Allow examiners to access specific methods
    }

    // View all examiners
    public function index()
    {
        $examiners = Examiner::all();
        return view('examiners.index', compact('examiners'));
    }

    // Show form to assign a thesis to an examiner
    public function assignThesisForm($examinerId)
    {
        // Fetch the examiner
        $examiner = Examiner::findOrFail($examinerId);

        // Fetch the theses that are already assigned to the examiner
        $assignedTheses = $examiner->documents;

        // Fetch available theses (approved final submissions that are not assigned to this examiner)
        $assignedThesisIds = $assignedTheses->pluck('id'); // IDs of theses already assigned

        // Get approved documents that represent the final submission and are not already assigned
        // We assume that "final submission" is indicated by the highest phase number for each user, and the document should be "approved"
        $availableTheses = Document::where('status', 'approved')
            ->whereNotIn('id', $assignedThesisIds)
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('documents')
                    ->where('status', 'approved')
                    ->groupBy('user_id');
            })
            ->get();

        return view('examiners.assign-thesis', compact('examiner', 'availableTheses', 'assignedTheses'));
    }

    // Store the assignment of a thesis to an examiner
    public function assignThesis(Request $request, $examinerId)
    {
        $examiner = Examiner::findOrFail($examinerId);

        // Validate that a thesis is selected
        $request->validate([
            'thesis_id' => 'required|exists:documents,id',
        ]);

        // Assign the thesis to the examiner
        $examiner->documents()->attach($request->thesis_id);

        return redirect()->route('examiner.list')->with('success', 'Thesis assigned successfully.');
    }

    public function examinerDashboard()
    {
        // Check if the logged-in user is an examiner
        $examiner = Auth::guard('examiner')->user();
        Log::info('Access granted to Examiner Dashboard', ['examiner' => Auth::guard('examiner')->user()]);

        // Check if the role is 'examiner'
        if ($examiner && $examiner->role === 'examiner') {
            $assignedTheses = $examiner->documents;
            return view('examiners.dashboard', compact('examiner', 'assignedTheses'));
        } else {
            Log::warning('Access denied for unauthenticated examiner access attempt.');
            return redirect('/')->with('error', 'Unauthorized access.');
        }
    }

    public function uploadCv(Request $request, $examinerId)
    {
        $examiner = Examiner::findOrFail($examinerId);

        // Validate file upload
        $request->validate([
            'cv' => 'required|file|mimes:pdf|max:2048', // Only allow PDFs
        ]);

        // Store the uploaded CV
        $cvPath = $request->file('cv')->store('cvs', 'public');

        // Update the examiner's CV path
        $examiner->cv_path = $cvPath;
        $examiner->save();

        return redirect()->route('examiner.dashboard')->with('success', 'CV uploaded successfully.');
    }
}
