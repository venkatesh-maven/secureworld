@extends('layouts.master')

@section('title', 'Spare Details')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Spare Details</h3>
                <a href="{{ route('spares.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $spare->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $spare->name }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $spare->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>{{ $spare->price }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $spare->description }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $spare->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $spare->updated_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
