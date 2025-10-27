@extends('layouts.master')
@section('title', 'Add New User')
@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Add New User</h3>
            </div>
            <script>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        toastr.error("{{ $error }}");
                    @endforeach
                @endif
                @if (session('success'))
                    toastr.success("{{ session('success') }}");
                @endif
            </script>
            <div class="block-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" 
                               value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" 
                               value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-control" required>
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" 
                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->role_name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection



