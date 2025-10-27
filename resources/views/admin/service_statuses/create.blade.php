
@extends('layouts.master')

@section('title', 'Add New Status')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Add New Status</h3>
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
                <form action="{{ route('service-statuses.store') }}" method="POST">
                    @csrf

                    {{-- Status Name --}}
                    <div class="mb-4">
                        <label class="form-label">Status Name</label>
                        <input type="text" class="form-control" name="name"
                               value="{{ old('name') }}" required>
                    </div>

                    {{-- Active Toggle --}}
                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('service-statuses.index') }}" class="btn btn-secondary">⬅ Back</a>
                        <button type="submit" class="btn btn-primary">Save Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
