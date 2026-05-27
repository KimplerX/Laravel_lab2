<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductSpaController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => Product::paginate(12)
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($validated);

        return to_route('products.index')->with('message', 'Товар успішно створено!');
    }
}