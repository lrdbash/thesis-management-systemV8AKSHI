<!-- resources/views/examiners/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Register Examiner</h1>
    <form action="{{ route('examiners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contact_details">Contact Details</label>
            <input type="text" name="contact_details" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cv">Upload CV (PDF)</label>
            <input type="file" name="cv" class="form-control-file" accept="application/pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Register Examiner</button>
    </form>
</div>
@endsection


