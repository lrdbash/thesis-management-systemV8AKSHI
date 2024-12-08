<!-- Navbar (include if it's in a partial or Blade component) -->
@include('layouts.app') <!-- Assuming your navbar is in a file called navbar.blade.php -->
<!DOCTYPE html>
<head>
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
</head>
<body>
    
    <div class="content-container">
        <h1 class="title">Intakes</h1>

        <table class="intake-table">
            <thead>
                <tr>
                    <th>Intake Name</th>
                    <th>Chapters</th>
                    <th>Final Submission</th>
                    <th>Presentation Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($intakes as $intake)
                <tr>
                    <td>{{ $intake->name }}</td>

                    <!-- Display chapter deadlines dynamically -->
                    <td>
                        @if(is_array($intake->chapters) && !empty($intake->chapters))
                            <ul>
                                @foreach ($intake->chapters as $chapter)
                                    <li>{{ $chapter['name'] ?? 'N/A' }}: {{ $chapter['deadline'] ?? 'N/A' }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No chapters available.</p>
                        @endif
                    </td>

                    <td>{{ $intake->final_submission_deadline }}</td>
                    <td>{{ $intake->presentation_date }}</td>
                    <td>
                        @if ($intake->status == 'closed')
                            <span style="background-color:red;color:white;">{{ ucfirst($intake->status) }}</span>
                        @else
                            {{ ucfirst($intake->status) }}
                        @endif
                    </td>
                    <td>
                        <form action="/admin/intakes/toggle/{{ $intake->id }}" method="POST">
                            @csrf
                            <button type="submit" class="toggle-button">Toggle Status</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="button-container">
            <a href="{{ route('admin.intakes.create') }}">
                <button class="create-button">Create New Intake</button>
            </a>
        </div>    
    </div>
</body>
</html>
