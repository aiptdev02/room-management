@extends('masteradmin.layout')

@section('title', 'Change Password')


@section('content')
<div class="container" style="max-width:600px;">
    <h3>Change Password</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('change-password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" required>
            <div class="form-text">Minimum 6 characters. Use a strong password.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-success">Change Password</button>
        <a href="{{ url('/master/dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
