<p>購入が完了しました</p>

<p>◆詳細</p>
@foreach ($carts as $cart)
  <tr style="background-color:#f5f5f5">
  <td align="right">品名：{{ $cart->item->name }}    </td></br>
  <td align="right">数量：{{ $cart->quantity }}個    </td></br>
  <td align="right">小計：{{ $cart->subtotal() }}円    </td></br></br>
@endforeach
</br>
<td>合計 </td><td>税込： {{ $totals }}円</td></br>