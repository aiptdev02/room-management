@extends('masteradmin.layout')

@section('title', 'Edit Property')

@section('content')
    <div class="container">
        <h2>Edit Property</h2>
        <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $property->name }}" required>
            </div>

            <div class="mb-3">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="{{ $property->location }}" required>
            </div>

            <div class="mb-3">
                <label>Total Rooms</label>
                <input type="text" name="total_rooms" class="form-control" value="{{ $property->total_rooms }}" required>
            </div>

            <div class="mb-3">
                <label>Details</label>
                <textarea name="details" class="form-control">{{ $property->details }}</textarea>
            </div>

            <div class="mb-3">
                <label>Featured Photo</label><br>
                @if ($property->featured_photo)
                    <img src="{{ asset($property->featured_photo) }}" width="100" class="me-2 mb-2">
                @endif
                <input type="file" name="featured_photo" class="form-control" multiple>
            </div>

            <div class="mb-3">
                <label>Photos</label><br>
                @if ($property->photos)
                    @foreach ($property->photos as $photo)
                        <img src="{{ asset($photo) }}" width="100" class="me-2 mb-2">
                    @endforeach
                @endif
                <input type="file" name="photos[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
