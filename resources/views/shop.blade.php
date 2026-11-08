@extends('layout')

@section('content')
    <h1>Shop</h1>
    <p class="muted">Pick some items, add a discount code if you have one, and place your order.</p>

    <form method="POST" action="{{ route('orders.store') }}" class="card">
        @csrf
        <table>
            <thead><tr><th>Product</th><th class="num">Price</th><th class="num">Quantity</th></tr></thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><strong>{{ $product->name }}</strong><br><span class="muted">{{ $product->description }}</span></td>
                    <td class="num">{{ \App\Support\Money::format($product->price) }}</td>
                    <td class="num"><input type="number" name="quantities[{{ $product->id }}]" min="0" max="99" value="{{ old('quantities.'.$product->id, 0) }}" aria-label="Quantity of {{ $product->name }}"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @error('quantities')<p class="error">{{ $message }}</p>@enderror

        <div class="row">
            <label>Discount code<br>
                <input name="discount_code" value="{{ old('discount_code') }}" placeholder="e.g. SAVE10" autocomplete="off">
                @error('discount_code')<span class="error" style="display:block">{{ $message }}</span>@enderror
            </label>
            <button type="submit">Place order</button>
        </div>
    </form>

    @if ($orders->isNotEmpty())
        <div class="card">
            <strong>Recent orders</strong>
            <table>
                <thead><tr><th>Order</th><th class="num">Subtotal</th><th class="num">Discount</th><th class="num">Charged</th></tr></thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td><a href="{{ route('orders.show', $order) }}">#{{ $order->id }}</a></td>
                        <td class="num">{{ \App\Support\Money::format($order->subtotal) }}</td>
                        <td class="num">−{{ \App\Support\Money::format($order->discount) }}</td>
                        <td class="num"><strong>{{ \App\Support\Money::format($order->total) }}</strong></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
