<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function __construct(Cart $cart) {
        $this->cart = $cart;
    }
    public function index() {
        $auth_id = Auth::id();
        $carts = Cart::where('user_id', $auth_id)->get();
        $subtotals = $this->subtotals($carts);
        $totals = $this->totals($carts);
        return view('cart.index', compact('carts', 'totals', 'subtotals'));
    }
    private function subtotals($carts) {
        $result = 0;
        foreach ($carts as $cart) {
            $result += $cart->subtotal();
        }
        return $result;
    }
    private function totals($carts) {
        $result = $this->subtotals($carts) + $this->tax($carts);
        return $result;
    }
    private function tax($carts) {
        $result = floor($this->subtotals($carts) * 0.1);
        return $result;
    }
    public function store(Request $request) {
        $cart = Cart::where('user_id',Auth::id())->where('item_id',$request->item_id)->first();
        
        if ($cart){
            $cart->quantity += $request->quantity;
            $cart->save();
        }else{
            $cart = new Cart;
            $cart->item_id = $request->item_id;
            $cart->user_id = Auth::id();
            $cart->quantity = $request->quantity;
            $cart->save();
        }
        return redirect(route('cart.index'));

        
    }
    public function destroy($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect('/cart');
    }

}
