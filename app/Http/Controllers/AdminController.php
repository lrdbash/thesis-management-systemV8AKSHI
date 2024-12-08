<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
        // Admin dashboard or landing page
        public function index()
        {
            // Here you could fetch any necessary data for the admin dashboard
            return view('admin.dashboard'); // Make sure you have an 'admin/dashboard.blade.php' file
        }
    // Show a list of all students for admin to assign supervisors
    public function showStudentList()
    {
        // Fetch users with the role of student along with their assigned intake and supervisor
        $students = User::where('role', 'student')->with(['intakes', 'assignedSupervisors'])->get();

        return view('admin.student-list', compact('students'));
    }

    // Method to show the form for assigning or updating a supervisor
    public function assignSupervisorForm(User $student)
    {
        $supervisors = User::where('role', 'staff')->get(); // Fetch all users with role 'staff'

        return view('admin.assign-supervisor', compact('student', 'supervisors'));
    }

    // Method to handle the assignment or update of a supervisor
    public function assignSupervisor(Request $request, User $student)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:users,id',
        ]);

        $supervisor = User::find($request->supervisor_id);

        // Assign or update supervisor for the student
        $student->assignedSupervisors()->syncWithoutDetaching([$supervisor->id]);

        return redirect()->route('admin.student.list')->with('success', 'Supervisor assigned/updated successfully.');
    }
}
