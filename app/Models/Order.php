<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property array<int, array{product_id: int, name: string, price: int, quantity: int}> $lines
 * @property int $subtotal
 * @property int $discount
 * @property int $total
 */
class Order extends Model
{
    protected $fillable = ['discount_code_id', 'lines', 'subtotal', 'discount', 'total'];

    protected function casts(): array
    {
        return [
            'lines' => 'array',
            'subtotal' => 'integer',
            'discount' => 'integer',
            'total' => 'integer',
        ];
    }

    public function discountCode(): BelongsTo
    {
        return $this->belongsTo(DiscountCode::class);
    }
}
