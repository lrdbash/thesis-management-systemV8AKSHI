<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Intake;
use App\Models\Event;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ThesisController extends Controller
{
    // Method to show the progress bar and deadlines for students
    public function showProgress()
    {
        // Get the currently authenticated user
        $user = auth()->user();
    
        // Assuming each student is assigned to one intake
        $intake = $user->intakes()->first();

        // Fetch assigned supervisor if any
        $assignedSupervisor = $user->assignedSupervisors()->first();

        $currentStep = 0; // Default to phase 1
        $currentStepStatus = 'active';
        $documentStatus = null; // Default status is null
        $supervisorComment = null; // To store supervisor comment if available

        if ($intake) {
            // Parse the chapters JSON to get the chapter information
            $chapters = json_decode($intake->chapters, true);

            // Define phases dynamically based on chapters
            $phases = [];
            foreach ($chapters as $index => $chapter) {
                $phases[] = [
                    'title' => "Phase " . ($index + 1) . ": " . $chapter['name'],
                    'description' => "<strong>Submission:</strong> Submit your " . $chapter['name'] . " for review.",
                    'deadline' => $chapter['deadline'],
                ];
            }

            // Add final submission phase
            $phases[] = [
                'title' => "Final Submission",
                'description' => "<strong>Final Review:</strong> Review thesis for any last changes and submit the final document.",
                'deadline' => $intake->final_submission_deadline,
            ];
        } else {
            $phases = [];
        }

        // Get the latest document submitted by the user, if available
        $latestDocument = $user->documents()->latest()->first();

        if ($latestDocument) {
            // Determine step status based on the document status
            $documentStatus = $latestDocument->status; // Assuming document has a 'status' attribute ('awaiting-approval', 'approved', 'disapproved')
            $currentStep = $latestDocument->phase - 1; // Use current phase from the document minus 1 for zero-based index

            if ($documentStatus == 'awaiting-approval') {
                $currentStepStatus = 'pending'; // Orange for awaiting approval
            } elseif ($documentStatus == 'approved') {
                $currentStepStatus = 'completed'; // Green for approved
                $currentStep++; // Only move to the next step if the latest document is approved
            } elseif ($documentStatus == 'disapproved') {
                $currentStepStatus = 'disapproved'; // Red for disapproved
                $supervisorComment = $latestDocument->comment; // Set supervisor comment
            }
        }

        return view('student.progress-bar', compact('intake', 'currentStep', 'currentStepStatus', 'documentStatus', 'phases', 'supervisorComment', 'assignedSupervisor'));
    }

    // Method to handle document submission by students
    public function submitDocument(Request $request)
    {
        $user = auth()->user();
        $assignedSupervisor = $user->assignedSupervisors()->first();

        // Validate that the student has a supervisor before submitting Phase 1
        $latestDocument = $user->documents()->latest()->first();
        $currentPhase = $latestDocument ? $latestDocument->phase : 1;

        if ($currentPhase == 1 && !$assignedSupervisor) {
            return redirect()->back()->with('error', 'You cannot submit a document for Phase 1 without an assigned supervisor.');
        }

        // Validate the uploaded file
        $request->validate([
            'document' => 'required|file|mimes:pdf,docx|max:10240', // Only allow PDF or DOCX files, max 10MB
        ]);

        // Store the file and get the file path in the documents folder
        $path = $request->file('document')->store('documents', 'public'); // Store in 'documents' directory in 'public' disk
        \Log::info("Document stored at path: " . $path);

        // Determine the current phase based on the latest document status
        if ($latestDocument && $latestDocument->status === 'disapproved') {
            // If the latest document was disapproved, stay in the current phase
            $currentPhase = $latestDocument->phase;
        } else {
            // Otherwise, move to the next phase
            $currentPhase = $this->determineCurrentPhase($user);
        }

        // Save the file path and other details in the database
        $document = new Document();
        $document->user_id = auth()->id(); // Assuming the user is authenticated
        $document->file_path = 'documents/' . basename($path); // Save path in 'documents' directory in the public disk
        $document->status = 'awaiting-approval'; // Set status to awaiting approval
        $document->phase = $currentPhase; // Set the current phase
        $document->save();

        return redirect()->back()->with('success', 'Document submitted successfully! Awaiting approval.');
    }

    // Method for supervisors to approve documents
    public function approveDocument($documentId)
    {
        $document = Document::findOrFail($documentId);
        $document->status = 'approved';
        $document->save();

        return redirect()->back()->with('success', 'Document approved successfully.');
    }

    // Method for supervisors to disapprove documents
    public function disapproveDocument(Request $request, $documentId)
    {
        $document = Document::findOrFail($documentId);
        $document->status = 'disapproved';
        $document->comment = $request->input('comment'); // Get comment from request
        $document->save();

        return redirect()->back()->with('success', 'Document disapproved successfully. Comment saved.');
    }
    
    // Method to determine the current phase of the thesis
    private function determineCurrentPhase($user)
    {
        $approvedDocuments = $user->documents()->where('status', 'approved')->count();

        // Determine the phase based on the number of approved documents
        return $approvedDocuments + 1; // Phase is based on the count of approved documents plus 1
    }

    // Method to show the student dashboard
    public function showStudentDashboard()
    {
        $user = auth()->user();

        // Assuming each student is assigned to one intake
        $intake = $user->intakes()->first(); // Gets the first assigned intake for the user

        // Pass intake to the student dashboard view
        return view('student.dashboard', compact('intake'));
    }

    // Method to show the list of students for admin
    public function showStudentList(Request $request)
    {
        // Fetch students with the role 'student' and their related intake
        $students = User::where('role', 'student')
                        ->with('intakes')
                        ->get();

        // Fetch supervisors with the role 'staff' to assign
        $supervisors = User::where('role', 'staff')->get();

        // Fetch all intakes for sorting/filtering purposes
        $intakes = Intake::all();

        // Apply sorting by intake if requested
        if ($request->has('intake_id') && $request->input('intake_id')) {
            $students = $students->filter(function ($student) use ($request) {
                return $student->intakes->first() && $student->intakes->first()->id == $request->input('intake_id');
            });
        }

        return view('admin.student-list', compact('students', 'supervisors', 'intakes'));
    }

    // Method to assign supervisor to a student
    public function assignSupervisor(Request $request, User $student)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:users,id'
        ]);

        // Assign supervisor to the student
        $student->assignedSupervisors()->syncWithoutDetaching([$request->supervisor_id]);

        return redirect()->back()->with('success', 'Supervisor assigned successfully!');
    }
}
