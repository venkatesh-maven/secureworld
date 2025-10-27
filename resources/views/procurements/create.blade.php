@extends('layouts.master')

@section('title', 'Add New Procurement')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Add New Procurement</h3>
            </div>
            <div class="block-content block-content-full">
                <form action="{{ route('procurements.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="spare_id" class="form-label">Select Spare</label>
                        <select class="form-control" id="spare_id" name="spare_id" required>
                            <option value="">-- Select Spare --</option>
                            @foreach($spares as $spare)
                                <option value="{{ $spare->id }}">{{ $spare->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Ordered" selected>Ordered</option>
                            <option value="Received">Received</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save Procurement</button>
                    <a href="{{ route('procurements.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
