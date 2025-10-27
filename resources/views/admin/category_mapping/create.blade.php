@extends('layouts.master')

@section('content')
<div class="container">
    <h4 class="mb-4">Add Category Mapping</h4>

    <form action="{{ route('category-mapping.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Product Category</label>
            <input type="text" name="product_category" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Field Category</label>
            <input type="text" name="field_category" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('category-mapping.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
