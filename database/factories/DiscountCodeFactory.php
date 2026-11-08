<?php

namespace Database\Factories;

use App\Models\DiscountCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DiscountCode>
 */
class DiscountCodeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('CODE##??')),
            'type' => DiscountCode::FIXED,
            'value' => 500,
        ];
    }

    public function percent(int $value): static
    {
        return $this->state(['type' => DiscountCode::PERCENT, 'value' => $value]);
    }

    public function fixed(int $pence): static
    {
        return $this->state(['type' => DiscountCode::FIXED, 'value' => $pence]);
    }
}
