<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

class CalculateProfitService
{
    public float $price;

    public float $grossAmount;

    public float $transactionFee;

    public float $vat = 0.12;

    public float $salesTax = 0.006;

    public float $sccp = 0.0001;

    public float $pse = 0.00005;

    public int $quantity;

    private function commission(): float
    {
        return $this->grossAmount >= 8000
            ? $this->grossAmount * 0.0025
            : 20.0;
    }

    public function __construct($quantity, $price)
    {
        $this->quantity     = $quantity;
        $this->price        = $price;
        $this->grossAmount  = $quantity * $price;
    }

    private function calculateBuyTransactionFee()
    {
        $grossAmount = $this->grossAmount;

        return $this->commission()
            + $this->pse * $grossAmount
            + $this->sccp * $grossAmount
            + $this->vat * $this->commission();
    }

    private function calculateSellTransactionFee()
    {
        $grossAmount = $this->grossAmount;

        return $this->commission()
            + $this->pse * $grossAmount
            + $this->sccp * $grossAmount
            + $this->vat * $this->commission()
            + $this->salesTax * $grossAmount;
    }

    /**
     * @throws ValidationException
     * @throws \Exception
     */
    public function calculateTotal($transactionType = null): float
    {
        // if the transaction type is not given, set it to buy
        $transactionType = $transactionType
            ? strtolower($transactionType)
            : 'buy';

        // validate if the transaction type is valid
        if (! in_array($transactionType, ['buy','sell'])) {
            throw new \Exception('Transaction type must either be "buy" or "sell"');
        }

        // return based on transaction type
        if ($transactionType == 'buy') {
            return $this->grossAmount + $this->calculateBuyTransactionFee();
        } else {
            return $this->grossAmount - $this->calculateSellTransactionFee();
        }
    }

    public function calculateBreakevenPrice()
    {
        $acquisitionCost = $this->grossAmount + $this->calculateBuyTransactionFee();
        $fixedCommission = 20 + 0.12 * 20;

        if ($this->grossAmount >= 8000) {
            return $this->quantity > 0
                ? $acquisitionCost / 0.99105 / $this->quantity
                : 0;
        } else {
            return $this->quantity > 0
                ? ($acquisitionCost - $fixedCommission) / (1 - $this->salesTax - $this->sccp - $this->pse) / $this->quantity
                : 0;
        }
    }
}
