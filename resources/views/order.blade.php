@extends('layout')

@section('title', "Order #{$order->id} · Northwind Supply")

@section('content')
    <h1>Thanks for your order</h1>
    <p class="muted">Order #{{ $order->id }} · placed {{ $order->created_at->format('j M Y, H:i') }}</p>

    <div class="card">
        <table>
            <thead><tr><th>Item</th><th class="num">Quantity</th><th class="num">Amount</th></tr></thead>
            <tbody>
            @foreach ($order->lines as $line)
                <tr>
                    <td>{{ $line['name'] }}</td>
                    <td class="num">{{ $line['quantity'] }} × {{ \App\Support\Money::format($line['price']) }}</td>
                    <td class="num">{{ \App\Support\Money::format($line['price'] * $line['quantity']) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <table class="totals" style="margin-top: 12px; max-width: 320px; margin-left: auto;">
            <tr><td>Subtotal</td><td class="num">{{ \App\Support\Money::format($order->subtotal) }}</td></tr>
            @if ($order->discountCode)
                <tr><td>Discount ({{ $order->discountCode->code }}, {{ $order->discountCode->label() }})</td><td class="num">−{{ \App\Support\Money::format($order->discount) }}</td></tr>
            @endif
            <tr class="total"><td>Charged</td><td class="num">{{ \App\Support\Money::format($order->total) }}</td></tr>
        </table>
    </div>

    <p><a href="{{ route('shop') }}">← Back to the shop</a></p>
@endsection
