@extends('layouts.app')
@section('content')
<body>
@if (0 < $carts->count())
        <table>
                <h1>購入確認画面</h1>
                <tr style="background-color:#e3f0fb">
                        <th>商品名</th>
                        <th>購入数</th>
                        <th>価格</th>
                </tr>
                @foreach ($carts as $cart)
                        <tr style="background-color:#f5f5f5">
                        <td align="right">{{ $cart->item->name }}</td>
                        <td align="right">{{ $cart->quantity }}</td>
                        <td align="right">{{ $cart->subtotal() }}</td>
                @endforeach
                <td style="background-color:#f5f5f5">
                        <td>合計</td>
                        <td>{{ $subtotals }}</td>
                        <td>税込: {{ $totals }}</td>
                        <td></td>
                </td>
        </table>
        <form action="/mail" method="get" class="item-form" enctype="multipart/form-data">
        <button type="submit" class="btn-sm btn-blue">購入する</button>
        </form>
        <form action="{{ asset('payment') }}" method="POST" class="text-center mt-5">
        {{ csrf_field() }}
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-amount="{{$totals}}"
            data-name="Stripe Demo"
            data-label="決済をする"
            data-description="これはStripeのデモです。"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="JPY">
        </script>
    </form>
@endif
<br>

<h2><a href="{{  route('cart.index') }}">カートへ戻る</a></h2>
</body>
@endsection