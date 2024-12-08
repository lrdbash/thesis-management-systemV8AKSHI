@extends('layouts.app')

@section('content')
<div class="content-container">
    <div class="row">
        <!-- Sidebar Section -->
        <div class="col-md-3">
            @include('admin.partials.sidebar')
        </div>

        <!-- Main Content Section -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Admin Dashboard
                </div>
                <div class="card-body">
                    <h1>Welcome to the Admin Dashboard</h1>
                    <p>Select an option from the panel to manage examiners and other administrative tasks.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <style>
        /* General styles */
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
    </style>
@endsection

