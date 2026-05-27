<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawDemoController extends Controller
{
    public function index()
    {
        DB::statement('CREATE TABLE IF NOT EXISTS log_entries (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            message VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )');
        
        DB::unprepared("INSERT INTO log_entries (message) VALUES ('Тестовий лог через unprepared')");

        DB::statement('CREATE TABLE IF NOT EXISTS raw_products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(150),
            price DECIMAL(10, 2),
            stock INTEGER
        )');

        DB::insert('INSERT INTO raw_products (name, price, stock) VALUES (?, ?, ?)', ['Товар A', 199.99, 10]);
        DB::insert('INSERT INTO raw_products (name, price, stock) VALUES (?, ?, ?)', ['Товар B', 45.00, 5]);

        $expensiveProducts = DB::select('SELECT * FROM raw_products WHERE price > ? ORDER BY price DESC', [100]);
        $lastId = DB::getPdo()->lastInsertId();
        $oneProduct = DB::select('SELECT * FROM raw_products WHERE id = :id', ['id' => $lastId]);

        $affected = DB::update('UPDATE raw_products SET price = ? WHERE id = ?', [149.99, $lastId]);
        $deleted = DB::delete('DELETE FROM raw_products WHERE price < ?', [50]);

        // 4. Транзакція
        DB::statement('CREATE TABLE IF NOT EXISTS raw_orders (id INTEGER PRIMARY KEY AUTOINCREMENT, total DECIMAL(10,2))');
        DB::statement('CREATE TABLE IF NOT EXISTS raw_order_items (id INTEGER PRIMARY KEY AUTOINCREMENT, order_id INT, product_id INT)');
        
        DB::transaction(function () use ($lastId) {
            DB::insert('INSERT INTO raw_orders (total) VALUES (?)', [149.99]);
            $orderId = DB::getPdo()->lastInsertId();
            
            DB::insert('INSERT INTO raw_order_items (order_id, product_id) VALUES (?, ?)', [$orderId, $lastId]);
            
            DB::update('UPDATE raw_products SET stock = stock - 1 WHERE id = ?', [$lastId]);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Всі raw-запити виконано успішно!',
            'select_with_question_mark' => $expensiveProducts,
            'select_with_named_param' => $oneProduct,
            'updated_rows_count' => $affected,
            'deleted_rows_count' => $deleted,
            'transaction' => 'Транзакція пройшла успішно'
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}