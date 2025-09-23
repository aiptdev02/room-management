@extends('masteradmin.layout')

@section('title', 'Edit Subadmin')

@section('content')
    <div class="container">
        <h3>Edit Subadmin - {{ $master->name }}</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('masters.update', $master) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input name="name" value="{{ old('name', $master->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username <span class="text-danger">*</span></label>
                <input name="username" value="{{ old('username', $master->username) }}" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">New Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Enter new password if you want to change">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Confirm new password">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Type / Role</label>
                <input name="type" value="{{ old('type', $master->type) }}" class="form-control" required>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('masters.indexList') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
