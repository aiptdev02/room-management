@extends('masteradmin.layout')

@section('title', 'Create Subadmin')

@section('content')
    <div class="container">
        <h3>Create Subadmin</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('masters.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username <span class="text-danger">*</span></label>
                <input name="username" value="{{ old('username') }}" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Type / Role <span class="text-danger">*</span></label>
                <input name="type" value="{{ old('type') }}" class="form-control"
                    placeholder="eg. manager, receptionist" required>
            </div>

            <button class="btn btn-success">Create</button>
            <a href="{{ route('masters.indexList') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
