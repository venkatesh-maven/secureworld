@extends('layouts.master')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Category Mapping</h4>

    <form action="{{ route('category-mapping.update', $mapping->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Product Category</label>
            <input type="text" name="product_category" class="form-control" value="{{ $mapping->product_category }}" required>
        </div>

        <div class="mb-3">
            <label>Field Category</label>
            <input type="text" name="field_category" class="form-control" value="{{ $mapping->field_category }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('category-mapping.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
