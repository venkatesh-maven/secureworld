@extends('layouts.master')

@section('title', 'Tickets List')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Tickets List</h3>
                <a href="{{ route('tickets.create') }}" class="btn btn-primary">+ Create Ticket</a>
            </div>

            <div class="block-content block-content-full">
                {{-- Success message --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table id="ticketsTable" class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>User</th>
                            <th>Status</th>
                            <th width="180px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->description }}</td>
                                <td>{{ $ticket->user ? $ticket->user->name : '-' }}</td>
                                <td>{{ $ticket->status }}</td>
                                <td>
                                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this ticket?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No tickets found.</td>
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
    @if(!$tickets->isEmpty())
    $('#ticketsTable').DataTable({
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




