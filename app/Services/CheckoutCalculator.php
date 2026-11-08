<?php

namespace App\Services;

use App\Models\DiscountCode;

/**
 * Works out what an order costs. All amounts are in pence.
 */
class CheckoutCalculator
{
    /**
     * @param  list<array{price: int, quantity: int}>  $lines
     * @return array{subtotal: int, discount: int, total: int}
     */
    public function totals(array $lines, ?DiscountCode $code = null): array
    {
        $subtotal = 0;

        foreach ($lines as $line) {
            $subtotal += $line['price'] * $line['quantity'];
        }

        $discount = $code ? min($this->discountFor($code, $subtotal), $subtotal) : 0;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => max($subtotal - $discount, 0),
        ];
    }

    private function discountFor(DiscountCode $code, int $subtotal): int
    {
        return $code->value;
    }
}
