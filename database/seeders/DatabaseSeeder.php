<?php

namespace Database\Seeders;

use App\Models\DiscountCode;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['Mechanical keyboard', 'Tactile switches, aluminium case.', 8900],
            ['Desk mat', 'Felt, 90 × 40 cm.', 1950],
            ['USB-C cable', 'Braided, 2 metres.', 999],
            ['Monitor arm', 'Gas spring, fits 17–32 inch screens.', 4500],
        ] as [$name, $description, $price]) {
            Product::query()->create(compact('name', 'description', 'price'));
        }

        DiscountCode::query()->create(['code' => 'SAVE10', 'type' => DiscountCode::PERCENT, 'value' => 10]);
        DiscountCode::query()->create(['code' => 'HALFPRICE', 'type' => DiscountCode::PERCENT, 'value' => 50]);
        DiscountCode::query()->create(['code' => 'WELCOME5', 'type' => DiscountCode::FIXED, 'value' => 500]);
    }
}
