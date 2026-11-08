<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $type Either "fixed" (value in pence) or "percent" (value is a percentage).
 * @property int $value
 */
class DiscountCode extends Model
{
    use HasFactory;

    public const FIXED = 'fixed';

    public const PERCENT = 'percent';

    protected $fillable = ['code', 'type', 'value'];

    protected function casts(): array
    {
        return ['value' => 'integer'];
    }

    public static function findByCode(string $code): ?self
    {
        return static::query()->where('code', strtoupper(trim($code)))->first();
    }

    public function label(): string
    {
        return $this->type === self::PERCENT
            ? "{$this->value}% off"
            : \App\Support\Money::format($this->value).' off';
    }
}
