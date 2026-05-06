<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function all() {
        return response()->json(DB::table('products')->get());
    }

    public function filter() {
        $data = DB::table('products')
            ->where('price', '>', 50)
            ->orWhere('stock', '<', 5)
            ->whereBetween('id', [1, 10])
            ->get();
        return response()->json($data);
    }

    public function selectedColumns() {
        $data = DB::table('products')
            ->select('name', 'price as cost')
            ->get();
        return response()->json($data);
    }

    public function paginated() {
        return response()->json(DB::table('products')->paginate(10));
    }

    public function aggregates() {
        return response()->json([
            'count' => DB::table('products')->count(),
            'sum'   => DB::table('products')->sum('price'),
            'avg'   => DB::table('products')->avg('price'),
            'min'   => DB::table('products')->min('price'),
            'max'   => DB::table('products')->max('price'),
        ]);
    }

    public function joinInner() {
        $data = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select('orders.id as order_id', DB::raw('SUM(order_items.quantity * products.price) as total_sum'))
            ->groupBy('orders.id')
            ->get();
        return response()->json($data);
    }

    public function joinLeft() {
        $data = DB::table('users')
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.name', 'orders.id as order_id')
            ->get();
        return response()->json($data);
    }

    public function joinRight() {
        $data = DB::table('products')
            ->rightJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', 'products.name as product_name')
            ->get();
        return response()->json($data);
    }

    public function insertUpdateDelete() {
        $id = DB::table('categories')->insertGetId(['name' => 'Тимчасова категорія']);
        
        DB::table('categories')->where('id', $id)->update(['name' => 'Оновлена категорія']);
        
        $deleted = DB::table('categories')->where('id', $id)->delete();

        return response()->json(['message' => 'Створено, оновлено та видалено успішно!', 'deleted_rows' => $deleted]);
    }
}