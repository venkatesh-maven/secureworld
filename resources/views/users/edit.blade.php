@extends('layouts.master')
@section('content')
<div class="container">
    <h2 class="mb-4">Edit User</h2>

    {{-- Show validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label"><strong>Name</strong></label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                   class="form-control" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label"><strong>Email</strong></label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                   class="form-control" required>
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label for="role_id" class="form-label"><strong>Role</strong></label>
            <select name="role_id" id="role_id" class="form-select" required>
                <option value="">-- Select Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->role_name) }}
                    </option>
                @endforeach
            </select>
        </div>
    {{-- Password (visible only to Super Admin) --}}
    @if(auth()->user() && auth()->user()->role->role_name === 'superadmin')
        <div class="mb-3">
            <label for="password" class="form-label"><strong>Password (optional)</strong></label>
            <input type="password" id="password" name="password" 
                   class="form-control" placeholder="Enter new password if changing">
            <small class="text-muted">Leave blank to keep the current password.</small>
        </div>
    @endif
        {{-- Buttons --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-primary">Update User</button>
        </div>
    </form>
</div>
@endsection

