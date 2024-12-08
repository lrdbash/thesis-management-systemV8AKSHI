@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Supervisor Dashboard</h1>
    <p> Welcome, {{ Auth::user()->name }}. Here you can see the list of students assigned to you and the documents they have submitted for review.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="content-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Submitted Documents</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            @if($student->documents->isEmpty())
                                No documents submitted yet.
                            @else
                                <ul>
                                    @foreach($student->documents as $document)
                                        @php
                                            $deadline = null;
                                            switch ($document->phase) {
                                                case 1:
                                                    $deadline = $student->intakes->first()->chapter_1_deadline ?? null;
                                                    break;
                                                case 2:
                                                    $deadline = $student->intakes->first()->chapter_2_deadline ?? null;
                                                    break;
                                                case 3:
                                                    $deadline = $student->intakes->first()->chapter_3_deadline ?? null;
                                                    break;
                                                case 4:
                                                    $deadline = $student->intakes->first()->final_submission_deadline ?? null;
                                                    break;
                                            }
                                        @endphp

                                        <li>
                                            <a href="{{ Storage::url($document->file_path) }}" target="_blank">
                                                Phase {{ $document->phase }} Submission
                                            </a>
                                            - Submitted on {{ $document->created_at->format('F j, Y') }}

                                            <span class="badge 
                                                @if($document->status === 'approved') badge-success 
                                                @elseif($document->status === 'awaiting-approval') badge-warning 
                                                @else badge-danger @endif">
                                                {{ ucfirst($document->status) }}
                                            </span>

                                            @if($deadline && $document->created_at->greaterThan($deadline))
                                                <span class="badge badge-danger">Past Deadline</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            @if(!$student->documents->isEmpty())
                                @foreach($student->documents as $document)
                                    @if($document->status === 'awaiting-approval')
                                        <form action="{{ route('document.approve', $document->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>

                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#disapproveModal-{{ $document->id }}">
                                            Disapprove
                                        </button>

                                        <div class="modal fade" id="disapproveModal-{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="disapproveModalLabel-{{ $document->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="disapproveModalLabel-{{ $document->id }}">Disapprove Document</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('document.disapprove', $document->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <textarea class="form-control" name="comments" placeholder="Enter disapproval comments" rows="4" required></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Disapprove</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
<style>
/* General styles */
body {
    font-family: 'Nunito', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container-fluid {
    width: 100%;
    padding: 30px;
    box-sizing: border-box;
    margin: 0;
}

.content-container {
    width: 90%;
    max-width: 100%;
    margin: 0 auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Title */
h1 {
    text-align: center;
    color: #333;
    font-size: 2rem;
    margin-bottom: 20px;
}

p {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 20px;
}

/* Alert message */
.alert {
    margin-top: 20px;
    text-align: center;
    font-size: 1rem;
}

/* Table styles */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    font-size: 16px;
}

.table th {
    background-color: #014a7f;
    color: white;
    font-weight: bold;
}

.table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

/* Badge styles */
.badge {
    font-size: 0.9rem;
    padding: 4px 10px;
    border-radius: 20px;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: white;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

.modal-dialog {
    max-width: 900px; /* Increased modal width for better content display */
}

.modal-content {
    border-radius: 8px;
}

/* Button styles */
.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
}

.btn-sm {
    padding: 6px 12px;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.8;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .content-container {
        padding: 15px;
        width: 100%;
    }

    h1 {
        font-size: 1.5rem;
    }

    .table th,
    .table td {
        font-size: 14px;
        padding: 10px;
    }

    .btn-sm {
        font-size: 12px;
        padding: 5px 10px;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 1.3rem;
    }

    .btn-sm {
        font-size: 11px;
        padding: 4px 8px;
    }
}
</style>