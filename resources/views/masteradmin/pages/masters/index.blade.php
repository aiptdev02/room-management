@extends('masteradmin.layout')

@section('title', 'Subadmins')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Subadmins</h3>
            <a href="{{ route('masters.create') }}" class="btn btn-primary">+ Create Subadmin</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th style="width:170px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($masters as $master)
                        <tr @if ($master->trashed()) class="table-secondary" @endif>
                            <td>{{ $master->id }}</td>
                            <td>{{ $master->name }}</td>
                            <td>{{ $master->username }}</td>
                            <td>{{ $master->type }}</td>
                            <td>{{ $master->created_at?->format('Y-m-d') }}</td>
                            <td>
                                @if ($master->trashed())
                                    <span class="badge bg-warning">Deleted</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>
                                @if (Auth::guard('masters')->user()->type === 'master')
                                    @if (!$master->trashed())
                                        <a href="{{ route('masters.edit', $master) }}"
                                            class="btn btn-sm btn-outline-primary">Edit</a>

                                        <form action="{{ route('masters.destroy', $master) }}" method="POST"
                                            class="d-inline-block" onsubmit="return confirm('Delete this subadmin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @else
                                        <form action="{{ route('masters.restore', $master->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-success">Restore</button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No subadmins found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
