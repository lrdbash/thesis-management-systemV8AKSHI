@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Supervisor to {{ $student->name }}</h1>

    <form action="{{ route('admin.assign.supervisor.submit', $student->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="supervisor">Select Supervisor:</label>
            <select name="supervisor_id" id="supervisor" class="form-control" required>
                <option value="">-- Select Supervisor --</option>
                @foreach($supervisors as $supervisor)
                    <option value="{{ $supervisor->id }}" {{ $student->assignedSupervisors->contains($supervisor->id) ? 'selected' : '' }}>
                        {{ $supervisor->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Assign/Update Supervisor</button>
        <a href="{{ route('admin.student.list') }}" class="btn btn-secondary">Back to Student List</a>
    </form>
</div>
@endsection
