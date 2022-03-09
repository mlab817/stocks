<?php

namespace App\Services;

class CalculateCostService
{
    public function execute(int $shares = 0, float $price = 0)
    {
        // calculate gross amount
        $base = $shares * $price;

        $commission = $base >= 8000
            ? $base * 0.0025
            : 20.0;

        $vat = 0.12 * $commission;

        $sccp = 0.0001 * $base;

        $pse = 0.00005 * $base;

        return round($base + $commission + $vat + $sccp + $pse, 2);
    }
}
