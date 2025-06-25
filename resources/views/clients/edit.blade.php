@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Edit Client</h2><br><br>

        <form action="{{ url('/clients/' . $client->hashid . '/update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $client->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Details</label>
                <input type="text" name="details" value="{{ old('details', $client->details) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $client->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ $client->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paused" {{ $client->status == 'paused' ? 'selected' : '' }}>Paused</option>
                    <option value="completed" {{ $client->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Logo</label>
                @if($client->logo)
                    <div class="mb-2">
                        <img src="{{ asset('images/client_logos/' . basename($client->logo)) }}" alt="Client Logo" width="100">
                    </div>
                @endif

                <input type="file" name="logo" class="form-control">
            </div><br>

            <div class="gap-2">
                <button type="submit" class="btn-primary-db">Update Client</button>
                <a href="{{ route('dashboard') }}">
                    <button class="btn-secondary-db">Cancel</button>
                </a>
            </div>
        </form>
    </div>
@endsection