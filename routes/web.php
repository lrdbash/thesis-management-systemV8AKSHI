<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExaminerController;
use App\Http\Controllers\ExaminerAuthController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

// Redirect root URL to forum posts
Route::get('/', function () {
    return redirect()->route('posts.index');
});

// Public Route for displaying all posts (Forum Homepage)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Authentication routes (default Laravel auth)
Auth::routes();

// General Dashboard route for authenticated users
Route::get('/dashboard', function () {
    return redirect()->route('posts.index');
})->middleware('auth');

// Messaging and Calendar routes for authenticated users
Route::group(['middleware' => ['auth']], function () {
    // Route::get('/messaging', [App\Http\Controllers\MessagingController::class, 'index'])->name('messaging.index');
    // Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
});

// Authenticated Routes for Students, Staff, and Admins (Forum Post Management)
Route::group(['middleware' => ['auth']], function() {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Routes for commenting
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Routes Restricted to Admins Only
Route::group(['middleware' => ['auth', 'role:admin']], function() {
    // Post management
    //Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Admin Dashboard route
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');

    // Examiner management by admin
    Route::get('/examiners', [ExaminerController::class, 'index'])->name('examiner.list'); // Changed to examiner.list for consistency
    Route::get('/examiners/{examiner}/assign-thesis', [ExaminerController::class, 'assignThesisForm'])->name('examiners.assignThesisForm');
    Route::post('/examiners/{examiner}/assign-thesis', [ExaminerController::class, 'assignThesis'])->name('examiners.assignThesis');
});

// Examiner Authentication Routes
Route::get('/examiner/login', [ExaminerAuthController::class, 'showLoginForm'])->name('examiner.login');
Route::post('/examiner/login', [ExaminerAuthController::class, 'login'])->name('examiner.login.submit');
Route::post('/examiner/logout', [ExaminerAuthController::class, 'logout'])->name('examiner.logout');

// Examiner Registration Routes
Route::get('/examiner/register', [ExaminerAuthController::class, 'showRegistrationForm'])->name('examiner.register');
Route::post('/examiner/register', [ExaminerAuthController::class, 'register'])->name('examiner.register.submit');

// Examiner Protected Routes (requires examiner authentication)
Route::middleware(['auth:examiner'])->group(function () {
    Route::get('/examiner/dashboard', [ExaminerController::class, 'examinerDashboard'])->name('examiner.dashboard');
    Route::post('/examiner/{examiner}/upload-cv', [ExaminerController::class, 'uploadCv'])->name('examiner.uploadCv');
});


//changes made by akshi
//test dashboard
Route::get('/charts', function () {
    return view('charts');
})->name('charts');

use App\Models\ThesisAllocation;
use App\Models\WordCloudData;
use App\Models\Program;
use App\Models\Program1;

Route::get('/treemap-data', function() {
    $allocations = ThesisAllocation::all();
    return response()->json($allocations);
});

Route::get('/word-cloud-data', function() {
    $words = WordCloudData::all();
    return response()->json($words);
});

Route::get('/programs', function() {
    // Fetch data from Program model
    $programs = Program::all();

    // Transform Program data
    $programData = $programs->map(function ($program) {
        return [
            'name' => $program->name,
            'students_count' => $program->students_count,
            'enrolled_students' => $program->enrolled_students,
            'thesis_topics' => $program->thesis_topics,
            'approved_theses' => $program->approved_theses,
            'disapproved_theses' => $program->disapproved_theses,
            'examiner_duration_0_2' => $program->examiner_duration_0_2,
            'examiner_duration_2_5' => $program->examiner_duration_2_5,
            'examiner_duration_5_10' => $program->examiner_duration_5_10,
            'examiner_duration_10_plus' => $program->examiner_duration_10_plus,
            'average_response_time' => $program->average_response_time,
        ];
    });

    // Fetch data from Program1 model (only the passed and failed columns)
    $programs1 = Program1::all(['name', 'passed_students', 'failed_students']);

    // Add passed_students and failed_students data to the Program data
    $programData = $programData->map(function ($program, $index) use ($programs1) {
        // Find the corresponding Program1 data by matching name
        $program1 = $programs1->firstWhere('name', $program['name']);
        
        // Add passed_students and failed_students if found
        if ($program1) {
            $program['passed_students'] = $program1->passed_students;
            $program['failed_students'] = $program1->failed_students;
        } else {
            // In case no matching name is found in Program1, you can set default values or leave them null
            $program['passed_students'] = null;
            $program['failed_students'] = null;
        }

        return $program;
    });

    // Return the combined data
    return response()->json($programData);
});



Route::get('/programs1', function() {

        $programs = Program1::all();

        return response()->json($programs);

});


//Changes made by Tristan
//Test Calendar
use App\Models\Intake;

// Route::get('/calendar', function () {
// $intakes = Intake::where('status','open')->get();

//     return view('calendar', compact('intakes'));
// });

// Route::get('/calendar_1', function () {
//     return view('calendar_1');
// });

use App\Http\Controllers\EventController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\GoogleCalendarController;


Route::get('/events', [EventController::class, 'fetchEvents']);
Route::get('/events1', [EventController::class, 'fetchEvents1']);
Route::get('/admin/intakes/create', [IntakeController::class, 'create'])->name('admin.intakes.create');
Route::post('/admin/intakes/store', [IntakeController::class, 'store'])->name('admin.intakes.store');
Route::get('/admin/intakes', [IntakeController::class, 'index'])->name('admin.intakes.list');
Route::post('/admin/intakes/toggle/{id}', [IntakeController::class, 'toggleStatus']);
Route::post('/admin/events/store', [EventController::class, 'store'])->name('events.store');
Route::post('/admin/events/update1', [EventController::class, 'update1'])->name('events.update1');
Route::post('/admin/events/update', [EventController::class, 'update'])->name('events.update');
Route::post('/admin/events/delete', [EventController::class, 'destroy'])->name('events.destroy');

Route::get('/google-login', [GoogleCalendarController::class, 'login']);
Route::get('/google-callback', [GoogleCalendarController::class, 'callback']);
Route::post('/sync-to-google', [GoogleCalendarController::class, 'syncToGoogle'])->name('sync-to-google');
Route::post('/sync-from-google', [GoogleCalendarController::class, 'syncFromGoogle'])->name('sync-from-google');
Route::get('/calendar_1', [CalendarController::class, 'show1'])->name('calendar_1');
Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar');

use App\Http\Controllers\ThesisController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupervisorController;

// Student Dashboard Route (Accessible only to authenticated users)
Route::middleware(['auth'])->group(function () {
    // Student Dashboard - Shows overview of student's thesis-related details
    Route::get('/student/dashboard', [ThesisController::class, 'showStudentDashboard'])->name('student.dashboard');

    // Student Progress Bar - Displays progress tracking phases and deadlines
    Route::get('/student/progress-bar', [ThesisController::class, 'showProgress'])->name('student.progress');

    // Submit Document - Allows students to upload thesis documents
    Route::post('/submit-document', [ThesisController::class, 'submitDocument'])->name('submit.document');
});

// Admin Routes (Accessible only by authenticated users with role: admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // List students for assigning supervisors
    Route::get('/admin/students', [AdminController::class, 'showStudentList'])->name('admin.student.list');

    // Route for assigning or updating a supervisor for a student
    Route::get('/admin/students/{student}/assign-supervisor', [AdminController::class, 'assignSupervisorForm'])->name('admin.assign.supervisor');
    Route::post('/admin/students/{student}/assign-supervisor', [AdminController::class, 'assignSupervisor'])->name('admin.assign.supervisor.submit');
});

// Supervisor Routes (Accessible only by authenticated users with role: staff)
Route::middleware(['auth', 'role:staff'])->group(function () {
    // Supervisor Dashboard - View assigned students and their submitted documents
    Route::get('/staff/supervisor-dashboard', [SupervisorController::class, 'showSupervisorDashboard'])->name('staff.supervisor.dashboard');


    //Route::patch('/document/{document}/approve', [SupervisorController::class, 'approveDocument'])->name('document.approve');
    //Route::patch('/document/{document}/disapprove', [SupervisorController::class, 'disapproveDocument'])->name('document.disapprove');
});
    // Routes for supervisor to approve or disapprove student submissions
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::patch('/document/{document}/approve', [ThesisController::class, 'approveDocument'])->name('document.approve');
    Route::patch('/document/{document}/disapprove', [ThesisController::class, 'disapproveDocument'])->name('document.disapprove');
});

//changes made by Mactilda
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/messages/{contactId}', [MessageController::class, 'show'])->name('messages.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


   Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
    
    // Route to display conversation with a specific contact
Route::get('/messages/{contact_id}', [MessageController::class, 'showConversation'])->name('messages.show');

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');

Route::get('/messages', [MessageController::class, 'conversation'])->name('messages.conversation');



});
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');



require __DIR__.'/auth.php';



