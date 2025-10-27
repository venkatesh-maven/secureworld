@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Ticket</h2>

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label"><strong>Title</strong></label>
            <input type="text" name="title" class="form-control" value="{{ $ticket->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Description</strong></label>
            <textarea name="description" class="form-control" rows="4" required>{{ $ticket->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Status</strong></label>
            <select name="status" class="form-select" required>
                <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                <option value="In Progress" {{ $ticket->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Resolved" {{ $ticket->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Priority</strong></label>
            <select name="priority" class="form-select" required>
                <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Assign To</strong></label>
            <select name="assigned_to" class="form-select">
                <option value="">-- Unassigned --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Ticket</button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
