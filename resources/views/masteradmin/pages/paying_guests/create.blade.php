@extends('masteradmin.layout')

@section('title', 'Add New Guest')
@section('content')
    <h2>Add New Guest</h2>
    <form action="{{ route('paying-guests.store') }}" method="POST" enctype="multipart/form-data" class="form-submit">
        @include('masteradmin.pages.paying_guests.form')
    </form>
@endsection
