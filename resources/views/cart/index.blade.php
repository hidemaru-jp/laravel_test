@extends('layouts.app')
@section('content')
<body>
@if (0 < $carts->count())
        <table>
                <h1>カート内容</h1>
                <tr style="background-color:#e3f0fb">
                        <th>商品名</th>
                        <th>購入数</th>
                        <th>価格</th>
                        <th>削除</th>
                </tr>
                @foreach ($carts as $cart)
                        <tr style="background-color:#f5f5f5">
                        <td align="right">{{ $cart->item->name }}</td>
                        <td align="right">{{ $cart->quantity }}</td>
                        <td align="right">{{ $cart->subtotal() }}</td>
                        <td><form action="/cart/{{$cart->id}}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <input type="submit" name="" value="Delete">
                                </form>
                        </td>
                @endforeach
                <td style="background-color:#f5f5f5">
                        <td>合計</td>
                        <td>{{ $subtotals }}</td>
                        <td>税込: {{ $totals }}</td>
                        <td></td>
                </td>
        </table>
@else
        <h1>カートに商品はありません</h1>
@endif
<br>
<h2><a href="{{  route('items.index') }}">商品一覧へ戻る</a></h2>
</body>
@endsection