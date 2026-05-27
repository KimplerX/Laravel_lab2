<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PriceCalculatorInterface;
use Inertia\Inertia;
use App\Jobs\ProcessOrder; 
class CheckoutController extends Controller
{
    public function index(PriceCalculatorInterface $calculator)
    {
        $cartItems = [
            ['id' => 1, 'name' => 'Ноутбук', 'price' => 25000, 'quantity' => 1],
            ['id' => 2, 'name' => 'Мишка', 'price' => 1000, 'quantity' => 2],
        ];

        $total = $calculator->calculateTotal($cartItems);
        $tax = $calculator->calculateTax($total);
        $totalWithDiscount = $calculator->applyDiscount($total, 10);

        return Inertia::render('Checkout/Index', [
            'cartItems' => $cartItems,
            'calculations' => [
                'total' => $total,
                'tax' => $tax,
                'totalWithDiscount' => $totalWithDiscount
            ]
        ]);
    }

    public function store(Request $request)
    {
        $orderId = 123; 

        event(new \App\Events\OrderPlaced($orderId));

        return to_route('checkout.index')->with('message', 'Замовлення створено!');
    }
}