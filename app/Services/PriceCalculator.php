<?php

namespace App\Services;

use App\Contracts\PriceCalculatorInterface;

class PriceCalculator implements PriceCalculatorInterface
{
    public function calculateTotal(array $items): float
    {
        return collect($items)->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    public function calculateTax(float $amount): float
    {
        return $amount * 0.20; 
    }

    public function applyDiscount(float $amount, float $percent): float
    {
        return $amount - ($amount * ($percent / 100));
    }
}