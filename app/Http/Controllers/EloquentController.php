<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class EloquentController extends Controller
{
    public function index()
    {
        $activeProducts = Product::where('is_active', true)->take(5)->get();
        return response()->json($activeProducts, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function store()
    {
        $product = Product::create([
            'category_id' => 1,
            'name' => 'Ноутбук ' . rand(100, 999),
            'price' => 25000.50,
            'stock' => 10,
            'is_active' => true
        ]);

        return response()->json(['message' => 'Створено успішно', 'product' => $product], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function bigData()
    {
        gc_collect_cycles(); 
        $memoryResults = [];

        Product::chunk(200, function ($products) {
            foreach ($products as $product) { $dummy = $product->name; }
        });
        $memoryResults['chunk_peak_memory_MB'] = round(memory_get_peak_usage() / 1024 / 1024, 2);
        memory_reset_peak_usage(); 

        Product::cursor()->each(function ($product) {
            $dummy = $product->name;
        });
        $memoryResults['cursor_peak_memory_MB'] = round(memory_get_peak_usage() / 1024 / 1024, 2);
        memory_reset_peak_usage();

        Product::lazy()->each(function ($product) {
            $dummy = $product->name;
        });
        $memoryResults['lazy_peak_memory_MB'] = round(memory_get_peak_usage() / 1024 / 1024, 2);

        return response()->json([
            'message' => 'Порівняння споживання пам\'яті на 50 000 записів',
            'results' => $memoryResults
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}