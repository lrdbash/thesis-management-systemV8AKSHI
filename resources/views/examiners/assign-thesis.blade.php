@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Final Submission to {{ $examiner->name }}</h1>

    <div class="row">
        <!-- Available Theses Dropdown -->
        <div class="col-md-6">
            <h3>Available Final Submissions for Assignment</h3>

            @if($availableTheses->isEmpty())
                <p>No available final submissions to assign.</p>
            @else
                <form action="{{ route('examiners.assignThesis', $examiner->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="thesis">Select Final Submission:</label>
                        <select name="thesis_id" id="thesis" class="form-select">
                            @foreach($availableTheses as $thesis)
                                <option value="{{ $thesis->id }}">
                                    Final Submission from {{ $thesis->user->name }} - Intake {{ optional($thesis->user->intakes->first())->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Assign Submission</button>
                </form>
            @endif
        </div>

        <!-- Already Assigned Theses List -->
        <div class="col-md-6">
            <h3>Already Assigned Final Submissions</h3>

            @if($assignedTheses->isEmpty())
                <p>No final submissions have been assigned yet.</p>
            @else
                <ul class="list-group">
                    @foreach($assignedTheses as $thesis)
                        <li class="list-group-item">
                            Final Submission from {{ $thesis->user->name }} - Intake {{ optional($thesis->user->intakes->first())->name }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
