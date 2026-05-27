<?php

namespace App\Contracts;

interface PriceCalculatorInterface
{
    public function calculateTotal(array $items): float;
    public function calculateTax(float $amount): float;
    public function applyDiscount(float $amount, float $percent): float;
}