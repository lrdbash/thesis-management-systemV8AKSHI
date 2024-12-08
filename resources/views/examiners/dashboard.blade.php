@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $examiner->name }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h3>Registration Information</h3>
            <ul>
                <li><strong>Registered At:</strong> {{ $examiner->registered_at->format('d M Y') }}</li>
                <li><strong>Registration Expires At:</strong> {{ $examiner->registration_expires_at->format('d M Y') }}</li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3>Assigned Documents (Final Submissions)</h3>
            @if($assignedTheses->isEmpty())
                <p>No documents have been assigned to you.</p>
            @else
                <ul>
                    @foreach ($assignedTheses as $document)
                        <li>
                            Final Submission (User ID: {{ $document->user_id }})
                            @if(!empty($document->title))
                                - Title: {{ $document->title }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-body">
            <h3>Update CV</h3>
            <form action="{{ route('examiner.uploadCv', ['examiner' => $examiner->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="cv">Upload CV</label>
                    <input type="file" name="cv" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload CV</button>
            </form>
        </div>
    </div>
</div>
@endsection
