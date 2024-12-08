

@section('content')
<div class="container">
    <!-- Progress Bar -->
    <div class="progress-bar">
        @foreach($phases as $index => $phase)
            <div class="step 
                @if($currentStep > $index) 
                    completed 
                @elseif($currentStep == $index && $currentStepStatus == 'pending') 
                    pending 
                @elseif($currentStep == $index && $currentStepStatus == 'disapproved') 
                    disapproved 
                @elseif($currentStep == $index) 
                    active 
                @endif">
                <span>{{ $index + 1 }}</span>
            </div>
        @endforeach
    </div>

    <!-- Phase Content -->
    <div class="phase-content">
        @if($currentStep < count($phases))
            <h2 id="phase-title">{{ $phases[$currentStep]['title'] }}</h2>
            <p id="phase-description">{!! $phases[$currentStep]['description'] !!}</p>

            <!-- Display Deadline for Each Phase -->
            @if($intake)
                <p class="deadline-info"><strong>Deadline:</strong> {{ $phases[$currentStep]['deadline'] }}</p>
            @endif
        @else
            <h2 id="phase-title">Completed</h2>
            <p id="phase-description">All phases have been successfully completed. Congratulations!</p>
        @endif

        <!-- Supervisor Info -->
        <div class="supervisor-info">
            @if($assignedSupervisor)
                <div class="alert alert-info">
                    <strong>Assigned Supervisor:</strong> {{ $assignedSupervisor->name }}
                </div>
            @else
                <div class="alert alert-warning">
                    You do not have a supervisor assigned yet. Please contact the administration to get a supervisor before continuing.
                </div>
            @endif
        </div>

        <!-- Status Alert -->
        @if($documentStatus == 'awaiting-approval')
            <div class="alert alert-warning">Awaiting Supervisor Approval.</div>
        @elseif($documentStatus == 'approved' && $currentStep < count($phases))
            <div class="alert alert-success">Document Approved! You can proceed to the next phase.</div>
        @elseif($documentStatus == 'disapproved')
            <div class="alert alert-danger">
                Document Disapproved. Please make the necessary changes and resubmit.
                @if(!empty($supervisorComment))
                    <br><strong>Supervisor's Comment:</strong> {{ $supervisorComment }}
                @endif
            </div>
        @endif

        <!-- Form for Submission or Resubmission -->
        @if($assignedSupervisor)
            @if($documentStatus == 'approved' && $currentStep < count($phases) || $documentStatus == null || $documentStatus == 'disapproved')
                <form id="submission-form" action="{{ route('submit.document') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label>
                        <input type="checkbox" name="confirm" required> I confirm all details
                    </label>
                    <input type="file" name="document" required aria-label="Upload Document">
                    <button type="submit">Submit Document</button>
                </form>
            @elseif($documentStatus == 'awaiting-approval')
                <div class="alert alert-info">You need supervisor approval before proceeding to the next phase.</div>
            @endif
        @else
            <div class="alert alert-danger">
                You cannot submit a document until you have an assigned supervisor.
            </div>
        @endif
    </div>

    <!-- Deadlines -->
    <div class="deadlines">
        <h3>Upcoming Deadlines</h3>
        <ul>
            @if($intake)
                @foreach ($phases as $index => $phase)
                    <li class="deadline-card">
                        {{ $phase['title'] }} Deadline: {{ \Carbon\Carbon::parse($phase['deadline'])->format('F j, Y') }}
                        @if($currentStep > $index)
                            <span class="badge badge-success">&#10004; Met</span>
                        @elseif(\Carbon\Carbon::parse($phase['deadline'])->isPast())
                            <span class="badge badge-danger">Past Deadline</span>
                        @endif
                    </li>
                @endforeach
                <li class="deadline-card">
                    Presentation Date: {{ \Carbon\Carbon::parse($intake->presentation_date)->format('F j, Y') }}
                </li>
            @else
                <li class="deadline-card">No intake assigned yet.</li>
            @endif
        </ul>
    </div>
</div>

<!-- Additional Styling for Progress Status -->
<!-- Additional Styling for Progress Status -->
<style>
 * Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f8; /* Light background */
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px; /* More rounded corners */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Background Pattern */
        .container::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            background-color: rgba(240, 244, 248, 0.1);
            border-radius: 12px;
            z-index: -1; /* Send to back */
        }

        /* Progress Bar */
        .progress-bar {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 40px; /* Increased margin */
        }

        .progress-bar::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 8px; 
            background-color: #e0e0e0;
            z-index: 0;
            transform: translateY(-50%);
            border-radius: 5px; 
        }

        .step {
            width: 80px; 
            height: 80px; 
            background-color: #2196F3; /* Blue for all steps initially */
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px; 
            font-weight: bold;
            position: relative;
            z-index: 1;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s; 
        }

        .step.completed {
            background-color : #4CAF50; /* Green for completed step */
        }

        .step-label {
            font-size: 14px; 
            text-align: center; 
            margin-top: 8px; 
            color: #4CAF50; 
        }

        /* Phase Content */
        .phase-content {
            margin-top: 20px; 
            padding: 20px; 
            background-color: #f9f9f9; 
            border-radius: 6px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
        }

        .phase-content h2 {
            font-size: 28px; 
            color: #333; 
            margin-bottom: 20px; 
        }

        .phase-content p {
            font-size: 18px; 
            margin-bottom: 10px; 
            color: #555; 
            line-height: 1.5; 
        }

        /* Form Styling */
        form {
            margin-top: 25px; 
            display: flex; 
            flex-direction: column; 
            gap: 20px; 
            align-items: center; 
        }

        form label {
            display: flex; 
            align-items: center; 
            font-size: 16px; 
            color: #333; 
        }

        form input[type="file"] {
            margin-top: 10px; 
            padding: 12px; 
            border-radius: 5px; 
            border: 1px solid #ddd; 
            font-size: 16px; 
            width: 100%; /* Full width for better usability */
            box-shadow: inset 0 -2px 5px rgba(0,0,0,0.1); /* Subtle shadow for depth */
            transition: border-color .3s, box-shadow .3s; /* Smooth transition for focus effect */
        }

        form input[type="file"]:focus { 
            border-color: #4CAF50; 
            box-shadow: inset 0 -2px 5px rgba(76,175,80,.5); 
        }

        form button {
            background-image: linear-gradient(to right, #4CAF50, #45a049); /* Gradient effect */
            color: #fff; 
            border: none; 
            padding: 14px 30px; 
            font-size: 18px; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: 500; 
            transition: background-color .3s, transform .3s, box-shadow .3s;
        }

        form button:hover { 
            background-image: linear-gradient(to right, #45a049, #4CAF50);  
            transform: scale(1.05);  
            box-shadow: 0 4px 15px rgba(76,175,80,.4); /* Shadow on hover */
        }

        form button[disabled] {  
            background-color: #ccc;  
            cursor: not-allowed;  
        }

        /* Deadlines Section */
.deadlines {
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    gap: .5rem;
}

.deadline-card {
    background-color: #fff;
    padding: .75rem;
    border-radius: .5rem;
    box-shadow: .2rem .2rem .5rem rgba(0, 0, 0, .1);
    border-left: .25rem solid #2196F3; /* Left border for emphasis */
    width: 100%; /* Ensure cards take full width available */
    transition: transform 0.3s ease-in-out; /* Smooth transition for animation */
}

.deadlines h3 {
    font-size: 22px;
    color: #333;
    margin-bottom: .75rem;
}

.deadlines ul {
    list-style: none;
    padding-left: .5rem;
    color: #555;
}

.deadlines li {
    font-size: 16px;
    padding: .5rem;
    border-bottom: .05rem solid #eee;
}

        /* Responsive Styles */
        @media (max-width: 600px) { 
            .progress-bar::before { left: 5%; right: 5%; } 
            .step { width: 60px; height: 60px; font-size: 18px;} 
            .step-label { font-size: 12px;} 
            .container { width: 90%; padding: 20px;} 
            form button { width: 100%;} 
            form input[type="file"] { width: auto;} 
            .deadline-card { width: auto;} /* Adjust card width on small screens */ 
        }
</style>
@endsection
@include('layouts.app')