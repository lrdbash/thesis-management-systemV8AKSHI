@section('content')
<div class="container mt-4">
    <h1 class="title mb-4">List of Examiners</h1>

    <div class="content-container">
        <div class="table-responsive">
            <table class="intake-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact Details</th>
                        <th>Email</th>
                        <th>CV</th>
                        <th>Registered At</th>
                        <th>Expires At</th>
                        <th>Assigned Documents</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($examiners as $examiner)
                        <tr>
                            <td>{{ $examiner->name }}</td>
                            <td>{{ $examiner->contact_details }}</td>
                            <td>{{ $examiner->email }}</td>
                            <td class="button-cell">
                                <a href="{{ Storage::url($examiner->cv_path) }}" target="_blank" class="btn btn-secondary btn-sm w-100">
                                    View CV
                                </a>
                            </td>
                            <td>{{ $examiner->registered_at->format('d M Y') }}</td>
                            <td>{{ $examiner->registration_expires_at->format('d M Y') }}</td>
                            <td class="button-cell">
                                @if($examiner->documents->isEmpty())
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        No Documents Assigned
                                    </button>
                                @else
                                    <select class="form-select form-select-sm w-100">
                                        @foreach($examiner->documents as $document)
                                            <option>Final Submission (User ID: {{ $document->user_id }})</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td class="button-cell">
                                <!-- Ensure the button is in the last td of the row -->
                                <a href="{{ route('examiners.assignThesisForm', $examiner->id) }}" class="toggle-button">
                                    Assign Thesis
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@include('layouts.app')

<style>
/* General styles */
body {
    font-family: 'Nunito', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}
.container {
    width: 100%;
    max-width: 100%; /* Allows container to use full width */
    padding: 30px;
    box-sizing: border-box;
    margin: 0;
}
.content-container {
    width: 100%;
    max-width: 100%; /* Full width of the screen */
    margin: 20px auto; /* Center content */
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Title */
.title {
    text-align: center;
    color: #333;
    font-size: 2rem;
    margin-bottom: 20px;
}

/* Button styles */
.button-container {
    margin: 20px 0;
    text-align: center;
}

.create-button {
    background-color: #014a7f;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.create-button:hover {
    background-color: #0056b3;
}

/* Table styles */
.intake-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.intake-table th,
.intake-table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    font-size: 16px;
}

.intake-table th {
    background-color: #014a7f;
    color: white;
    font-weight: bold;
}

.intake-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.intake-table tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

.toggle-button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.toggle-button:hover {
    background-color: #218838;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .content-container {
        padding: 15px;
        width: 95%;
    }

    .create-button {
        font-size: 16px;
        padding: 10px 25px;
    }

    .intake-table th,
    .intake-table td {
        font-size: 14px;
        padding: 10px;
    }
}

@media (max-width: 480px) {
    .title {
        font-size: 1.5rem;
    }

    .create-button {
        font-size: 14px;
        padding: 8px 20px;
    }
}

</style>