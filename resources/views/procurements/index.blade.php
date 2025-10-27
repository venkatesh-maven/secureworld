@extends('layouts.master')

@section('title', 'Procurements List')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Procurements</h3>
                <a href="{{ route('procurements.create') }}" class="btn btn-primary">Add New Procurement</a>
            </div>
            <div class="block-content block-content-full">
                <table id="procurementsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Spare</th>
                            <th>Quantity</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($procurements as $procurement)
                        <tr>
                            <td>{{ $procurement->id }}</td>
                            <td>{{ $procurement->spare->name ?? '-' }}</td>
                            <td>{{ $procurement->quantity }}</td>
                            <td>{{ $procurement->supplier }}</td>
                            <td>{{ $procurement->status }}</td>
                            <td>
                                <a href="{{ route('procurements.edit', $procurement->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('procurements.destroy', $procurement->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($procurements->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No procurements available.</td>
                        </tr>
                        @endif
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
    @if(!$procurements->isEmpty())
        $('#procurementsTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            paging: true,
            searching: true,
            ordering: true
        });
    @endif
});


</script>
@endpush






