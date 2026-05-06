<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelationshipController extends Controller
{
    public function demonstrate()
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Тестовий Користувач', 'password' => bcrypt('password')]
        );

        if (!$user->profile) {
            $user->profile()->create(['phone' => '123-456-7890', 'address' => 'вул. Тестова, 1']);
        }

        if ($user->orders()->count() == 0) {
            $order = $user->orders()->create([]);
            $product = Product::first();
            if ($product) {
                 $order->items()->create(['product_id' => $product->id, 'quantity' => 2, 'price' => $product->price]);
            }
        }

        $results = [];

        $results['user_profile'] = User::first()->profile;

        $category = Category::first();
        $results['category_products_count'] = $category ? $category->products()->count() : 0;

        $results['eager_loaded_products'] = Product::with('category')->take(3)->get();

        $results['deep_eager_loading'] = User::with(['profile', 'orders.items.product'])->first();

        $results['users_with_orders'] = User::has('orders')->get();

        $results['users_with_orders_count'] = User::withCount('orders')->get();

        return response()->json([
            'message' => 'Демонстрація Eloquent Relationships успішна!',
            'data' => $results
        ]);
    }
}