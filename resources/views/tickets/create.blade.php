@extends('layouts.master')

@section('title', 'Add New Ticket')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Add New Ticket</h3>
            </div>

            {{-- Error + Success Messages --}}
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
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" 
                               value="{{ old('title') }}" required>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4" required>{{ old('description') }}</textarea>
                    </div>

                    {{-- Assign User --}}
                    <div class="mb-4">
                        <label class="form-label">Assign User</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Default Status --}}
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Open" selected>Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Resolved">Resolved</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">⬅ Back</a>
                        <button type="submit" class="btn btn-primary">Create Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

