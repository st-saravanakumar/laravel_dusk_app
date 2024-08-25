@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <h1 class="mb-4">Product Details</h1>

        <div class="mb-3">
            <h5 class="card-title">Name:</h5>
            <p class="card-text">{{ $product->name }}</p>
        </div>

        <div class="mb-3">
            <h5 class="card-title">Price:</h5>
            <p class="card-text">${{ number_format($product->price, 2) }}</p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>
</div>
@endsection
