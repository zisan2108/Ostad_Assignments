@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="text-center mb-4">Product Details</h1>

    <div class="card">
        <div class="card-header">
            <h5>{{ $product->name }}</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Product ID:</strong> {{ $product->product_id }}
            </div>
            <div class="mb-3">
                <strong>Description:</strong>
                <p>{{ $product->description ?? 'N/A' }}</p>
            </div>
            <div class="mb-3">
                <strong>Price:</strong> ${{ number_format($product->price, 2) }}
            </div>
            <div class="mb-3">
                <strong>Stock:</strong> {{ $product->stock ?? 'N/A' }}
            </div>
            <div class="mb-3">
                <strong>Image:</strong>
                @if ($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" class="img-fluid" style="max-width: 300px;">
                @else
                    <p>No Image Available</p>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('products.edit',  $product->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('products.destroy',  $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
