<?php

namespace Tests\Feature;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_shop_lists_products(): void
    {
        Product::factory()->create(['name' => 'Desk mat', 'price' => 1950]);

        $this->get('/')->assertOk()->assertSee('Desk mat')->assertSee('£19.50');
    }

    public function test_an_order_without_a_code_is_charged_the_subtotal(): void
    {
        $mat = Product::factory()->create(['price' => 1950]);
        $cable = Product::factory()->create(['price' => 999]);

        $this->post('/orders', ['quantities' => [$mat->id => 2, $cable->id => 1]])->assertRedirect();

        $order = Order::query()->sole();
        $this->assertSame(4899, $order->subtotal);
        $this->assertSame(0, $order->discount);
        $this->assertSame(4899, $order->total);
    }

    public function test_a_fixed_amount_code_is_taken_off_the_total(): void
    {
        $mat = Product::factory()->create(['price' => 1950]);
        DiscountCode::factory()->fixed(500)->create(['code' => 'WELCOME5']);

        $this->post('/orders', ['quantities' => [$mat->id => 1], 'discount_code' => 'welcome5'])->assertRedirect();

        $this->assertSame(1450, Order::query()->sole()->total);
    }

    public function test_an_unknown_code_is_rejected(): void
    {
        $mat = Product::factory()->create();

        $this->post('/orders', ['quantities' => [$mat->id => 1], 'discount_code' => 'NOPE'])
            ->assertSessionHasErrors('discount_code');

        $this->assertSame(0, Order::query()->count());
    }
}
