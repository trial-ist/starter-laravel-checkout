<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use App\Services\CheckoutCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        return view('shop', [
            'products' => Product::query()->orderBy('name')->get(),
            'orders' => Order::query()->latest('id')->limit(5)->get(),
        ]);
    }

    public function store(Request $request, CheckoutCalculator $calculator): RedirectResponse
    {
        $validated = $request->validate([
            'quantities' => ['required', 'array'],
            'quantities.*' => ['nullable', 'integer', 'min:0', 'max:99'],
            'discount_code' => ['nullable', 'string', 'max:32'],
        ]);

        $products = Product::query()->findMany(array_keys($validated['quantities']))->keyBy('id');
        $lines = [];

        foreach ($validated['quantities'] as $productId => $quantity) {
            if ((int) $quantity > 0 && $products->has($productId)) {
                $product = $products[$productId];
                $lines[] = ['product_id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'quantity' => (int) $quantity];
            }
        }

        if ($lines === []) {
            throw ValidationException::withMessages(['quantities' => 'Add at least one item to your basket.']);
        }

        $code = null;

        if (filled($validated['discount_code'] ?? null)) {
            $code = DiscountCode::findByCode($validated['discount_code']);

            if ($code === null) {
                throw ValidationException::withMessages(['discount_code' => "That discount code isn't valid."]);
            }
        }

        $totals = $calculator->totals($lines, $code);

        $order = Order::query()->create([
            'discount_code_id' => $code?->id,
            'lines' => $lines,
            ...$totals,
        ]);

        return redirect()->route('orders.show', $order);
    }

    public function show(Order $order): View
    {
        return view('order', ['order' => $order->load('discountCode')]);
    }
}
