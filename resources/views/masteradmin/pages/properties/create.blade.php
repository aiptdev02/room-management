@extends('masteradmin.layout')

@section('title', 'Add Property')

@section('content')
    <h2>Add Property</h2>
    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Details</label>
            <textarea name="details" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Featured Photo</label>
            <input type="file" name="featured_photo" class="form-control" multiple>
        </div>

        <div class="mb-3">
            <label>Photos</label>
            <input type="file" name="photos[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
@endsection
