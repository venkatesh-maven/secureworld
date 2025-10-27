@extends('layouts.master')

@section('title', 'Service Status List')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                <h3 class="block-title">Service Status List</h3>
                <a href="{{ route('service-statuses.create') }}" class="btn btn-primary">+ Add New Status</a>
            </div>

            <div class="block-content block-content-full">
                {{-- Success message --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table id="statusTable" class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Status Name</th>
                            <th>Active</th>
                            <th width="180px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($statuses as $status)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $status->name }}</td>
                                <td>{{ $status->is_active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('service-statuses.edit', $status->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('service-statuses.destroy', $status->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this status?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No statuses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    @if(!$statuses->isEmpty())
    $('#statusTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', className: 'btn btn-sm btn-secondary' },
            { extend: 'csv', className: 'btn btn-sm btn-info' },
            { extend: 'excel', className: 'btn btn-sm btn-success' },
            { extend: 'pdf', className: 'btn btn-sm btn-danger' },
            { extend: 'print', className: 'btn btn-sm btn-primary' }
        ],
        paging: true,
        searching: true,
        ordering: true
    });
    @endif

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif
});
</script>
@endpush
