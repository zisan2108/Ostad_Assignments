<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('product_id', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
        }

        if ($request->filled('sort')) {
            $query->orderBy($request->sort, $request->order ?? 'asc');
        }

        $products = $query->paginate(10);

        return view('products.index', compact('products'));
        
    }

    public function create()
    {
        return view('products.create');
    }

    
    public function store(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|unique:products',
        'name' => 'required',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'stock' => 'nullable|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    
    $product = new Product($validated);

    
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/'), $imageName);
        $product->image = $imageName;
    }

    
    $product->save();

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}

   
    public function show($id)
    {
        $product=Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product=Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }
    public function update(Request $request, $id)
    {
        $product=Product::findOrFail($id);
        $validated = $request->validate([
            'product_id' => 'required|unique:products,product_id,' . $product->id,
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ]);
    
   
        $product->product_id = $validated['product_id'];
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
    
     
        if ($request->hasFile('image')) {
           
            if ($product->image) {
                $oldImagePath = public_path('images/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); 
                }
            }
    
      
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/'), $imageName);
            $product->image = $imageName; 
        }
    
   
        $product->save();
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    

    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index');
    }
}
