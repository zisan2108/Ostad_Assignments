
@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="text-center mb-4">Product Management</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex" method="GET" action="{{ route('products.index') }}">
            <input class="form-control me-2" type="search" name="search" placeholder="Search by ID or Description" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
        
        <div>
            <a href="{{ route('products.index', ['sort' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="btn btn-secondary me-2">Sort by Name</a>
            <a href="{{ route('products.index', ['sort' => 'price', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="btn btn-secondary">Sort by Price</a>
        </div>
        
        <a href="{{ route('products.create') }}" class="btn btn-success">Add New Product</a>
    </div>
    
   
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->name }}</td>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('images/' . $product->image) }}" alt="Product Image"
                            width="50" height="50">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ ($product->description) }}</td>
                <td>{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

  
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
