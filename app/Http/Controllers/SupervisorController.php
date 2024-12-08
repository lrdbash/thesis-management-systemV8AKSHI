<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    // Method to show the supervisor's dashboard
    public function showSupervisorDashboard()
    {
        // Get the currently authenticated supervisor
        $supervisor = auth()->user();

        // Get the list of students assigned to this supervisor along with their submitted documents
        $students = $supervisor->supervisedStudents()->with('documents')->get();

        return view('staff.supervisor-dashboard', compact('students'));
    }
}
