

@section('content')
<div class="container">
    <h1 class="title">Student List</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="content-container">
        <table class="intake-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Intake</th>
                    <th>Assigned Supervisor</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            @if($student->intakes->isNotEmpty())
                                {{ $student->intakes->pluck('name')->join(', ') }}
                            @else
                                No Intake Assigned
                            @endif
                        </td>
                        <td>
                            @if($student->assignedSupervisors->isNotEmpty())
                                {{ $student->assignedSupervisors->pluck('name')->join(', ') }}
                            @else
                                Not Assigned
                            @endif
                        </td>
                        <td>
                            <!-- Assign or Update Supervisor link/button -->
                            @if($student->assignedSupervisors->isNotEmpty())
                                <a href="{{ route('admin.assign.supervisor', $student->id) }}" class="toggle-button">Update Supervisor</a>
                            @else
                                <a href="{{ route('admin.assign.supervisor', $student->id) }}" class="toggle-button">Assign Supervisor</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
            padding: 0px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }
        .content-container {
            max-width: 1200px;
            margin: 50px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            color: #333;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .button-container {
            margin: 20px 0;
            text-align: center;
        }

        .create-button {
            background-color: #014a7f; /* Bootstrap Primary color */
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
            background-color: #28a745; /* Bootstrap Success color */
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
