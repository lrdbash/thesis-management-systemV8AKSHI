<?php

namespace App\Http\Controllers;

use App\Models\Examiner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\ThesisAllocation;
use Carbon\Carbon;


class ExaminerAuthController extends Controller
{
    // Show examiner login form
    public function showLoginForm()
    {
        return view('auth.examiner-login');
    }

    // Handle examiner login
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log in using the examiner guard
        $credentials = $request->only('email', 'password');
        Log::info('Attempting to login examiner with credentials:', $credentials);

        if (Auth::guard('examiner')->attempt($credentials)) {
            Log::info('Examiner logged in successfully.');
            // Redirect to the examiner dashboard after successful login
            return redirect()->route('examiner.dashboard')->with('success', 'Logged in successfully.');
        }

        Log::info('Login attempt failed.');
        // If login attempt fails, redirect back to login with an error message
        return back()->withErrors(['email' => 'Invalid credentials or not registered as an examiner.']);
    }

    // Examiner logout
    public function logout()
    {
        Auth::guard('examiner')->logout(); // Use the 'examiner' guard
        return redirect()->route('examiner.login')->with('success', 'Logged out successfully.');
    }

    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.examiner-register'); // Return the examiner's registration view
    }

    // Handle examiner registration

    public function register(Request $request)
    {
        try {
            // Validate the form data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:examiners',
                'password' => 'required|string|min:8|confirmed',
                'contact_details' => 'required|string|max:255',
                'cv' => 'required|file|mimes:pdf|max:2048', // CV must be a PDF
            ]);
    
            // Check if the validation fails and redirect with errors
            if ($validator->fails()) {
                Log::warning('Validation failed during examiner registration:', $validator->errors()->toArray());
    
                return redirect()->back()
                    ->withErrors($validator) // Pass validation errors to the view
                    ->withInput();           // Keep input data in case of error
            }
    
            // Store the CV
            $cvPath = $request->file('cv')->store('cvs', 'public');
    
            // Log the data being used for the examiner creation
            Log::info('Attempting to register examiner with data:', $request->all());
    
            // Create the examiner
            $examiner = Examiner::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'contact_details' => $request->contact_details,
                'cv_path' => $cvPath,
                'registered_at' => now(),
                'registration_expires_at' => now()->addYears(4), // Registration valid for 4 years
            ]);
    
            // Log success
            Log::info('Examiner registered successfully.');
    
            // Automatically log the examiner in
           // Auth::guard('examiner')->login($examiner);
    
            // Ensure a ThesisAllocation record is created for the current year with the examiner's name as the label
            $currentYear = Carbon::now()->year;
    
            // Always create a new ThesisAllocation record
            ThesisAllocation::create([
                'label' => $examiner->name,   // The name of the examiner will be the label
                'parent' => $currentYear,      // The current year will be the parent
                'value' => 15,                  // The initial value is set to 0
            ]);
    
            // Log the thesis allocation process
            Log::info('Thesis Allocation created for the year: ' . $currentYear);
    
            // Redirect to examiner dashboard
           // return redirect()->route('examiner.dashboard')->with('success', 'Registration successful.');
    
            return redirect()->back();
    
        } catch (\Exception $e) {
            // Log the exception with full details
            Log::error('Error during examiner registration:', ['error' => $e->getMessage()]);
    
            return back()->with('error', 'An error occurred during registration.');
        }
    }

    // Validator method for custom registration validation (optional, not necessary anymore)
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:examiners',
            'password' => 'required|string|min:8|confirmed',
            'contact_details' => 'required|string|max:255',
            'cv' => 'required|file|mimes:pdf|max:2048', // CV file should be a PDF
        ]);
    }

    // Create a new examiner (this logic is integrated into the register function)
    protected function create(array $data)
    {
        // Handle CV file upload
        $cvPath = request()->file('cv')->store('cvs', 'public');

        return Examiner::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'contact_details' => $data['contact_details'],
            'cv_path' => $cvPath,
            'registered_at' => now(),
            'registration_expires_at' => now()->addYears(4), // Set registration to expire in 4 years
        ]);
    }
}
