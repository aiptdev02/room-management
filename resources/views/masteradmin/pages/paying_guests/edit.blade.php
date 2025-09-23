@extends('masteradmin.layout')

@section('title', 'Edit Guest')
@section('content')
    <h2>Edit Guest</h2>
    <form action="{{ route('paying-guests.update', $payingGuest->id) }}" method="POST" enctype="multipart/form-data" class="form-submit">
        @method('PUT')
        @include('masteradmin.pages.paying_guests.form', ['guest' => $payingGuest])
    </form>
@endsection
