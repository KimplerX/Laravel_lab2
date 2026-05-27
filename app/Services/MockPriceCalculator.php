<?php

namespace App\Services;

use App\Contracts\PriceCalculatorInterface;

class MockPriceCalculator implements PriceCalculatorInterface
{
    public function calculateTotal(array $items): float
    {
        return 999.99; 
    }

    public function calculateTax(float $amount): float
    {
        return 0.0; 
    }

    public function applyDiscount(float $amount, float $percent): float
    {
        return 50.0; 
    }
}