@extends('layouts.master')

@section('content')
<div class="container">
    <h4 class="mb-4">Category Mappings</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('category-mapping.create') }}" class="btn btn-primary mb-3">+ Add New</a>

    <table class="table table-bordered table-sm">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Product Category</th>
                <th>Field Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mappings as $mapping)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mapping->product_category }}</td>
                <td>{{ $mapping->field_category }}</td>
                <td>
                    <a href="{{ route('category-mapping.edit', $mapping->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('category-mapping.destroy', $mapping->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this mapping?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
