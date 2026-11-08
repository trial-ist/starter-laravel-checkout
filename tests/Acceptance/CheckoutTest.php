<?php

namespace Tests\Acceptance;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Acceptance tests for the "fix a failing checkout" trial, run at submit by
 * confirm.sh. They go through HTTP so they pass however the calculator is structured.
 */
class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @param array<int, int> $quantities */
    private function order(array $quantities, ?string $code = null): Order
    {
        $this->post('/orders', array_filter(['quantities' => $quantities, 'discount_code' => $code]))
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        return Order::query()->latest('id')->firstOrFail();
    }

    public function test_a_percentage_code_takes_that_percentage_off(): void
    {
        $keyboard = Product::factory()->create(['price' => 5000]);
        DiscountCode::factory()->percent(10)->create(['code' => 'SAVE10']);

        $order = $this->order([$keyboard->id => 1], 'SAVE10');

        $this->assertSame(5000, $order->subtotal);
        $this->assertSame(500, $order->discount);
        $this->assertSame(4500, $order->total);
    }

    public function test_a_percentage_code_applies_to_the_whole_basket(): void
    {
        $keyboard = Product::factory()->create(['price' => 8900]);
        $mat = Product::factory()->create(['price' => 1950]);
        DiscountCode::factory()->percent(25)->create(['code' => 'QUARTER']);

        $order = $this->order([$keyboard->id => 1, $mat->id => 2], 'quarter');

        $this->assertSame(12800, $order->subtotal);
        $this->assertSame(3200, $order->discount);
        $this->assertSame(9600, $order->total);
    }

    public function test_a_hundred_percent_code_makes_the_order_free(): void
    {
        $mat = Product::factory()->create(['price' => 1950]);
        DiscountCode::factory()->percent(100)->create(['code' => 'FREE']);

        $this->assertSame(0, $this->order([$mat->id => 3], 'FREE')->total);
    }

    public function test_fixed_amount_codes_still_work(): void
    {
        $cable = Product::factory()->create(['price' => 1999]);
        DiscountCode::factory()->fixed(500)->create(['code' => 'WELCOME5']);

        $order = $this->order([$cable->id => 1], 'WELCOME5');

        $this->assertSame(500, $order->discount);
        $this->assertSame(1499, $order->total);
    }

    public function test_a_fixed_code_larger_than_the_basket_never_goes_negative(): void
    {
        $cable = Product::factory()->create(['price' => 999]);
        DiscountCode::factory()->fixed(2000)->create(['code' => 'BIG']);

        $order = $this->order([$cable->id => 1], 'BIG');

        $this->assertSame(999, $order->discount);
        $this->assertSame(0, $order->total);
    }

    public function test_orders_without_a_code_are_unchanged(): void
    {
        $mat = Product::factory()->create(['price' => 1950]);

        $order = $this->order([$mat->id => 2]);

        $this->assertSame(0, $order->discount);
        $this->assertSame(3900, $order->total);
    }
}
