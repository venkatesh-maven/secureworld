@extends('layouts.master')

@section('title', 'Spares List')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Spares</h3>
                <a href="{{ route('spares.create') }}" class="btn btn-primary">Add New Spare</a>
            </div>
            <div class="block-content block-content-full">
                <table id="sparesTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($spares as $spare)
                        <tr>
                            <td>{{ $spare->id }}</td>
                            <td>{{ $spare->name }}</td>
                            <td>{{ $spare->quantity }}</td>
                            <td>{{ $spare->price }}</td>
                            <td>{{ $spare->description }}</td>
                            <td>
                                <a href="{{ route('spares.edit', $spare->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('spares.destroy', $spare->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($spares->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No spares available.</td>
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
    @if(!$spares->isEmpty())
    $('#sparesTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
     @endif
});
</script>
@endpush



