<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyCompleted;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
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

    public function complete() {
        return view('cart.complete');
    }

    public function confirm() {
        $auth_id = Auth::id();
        $carts = Cart::where('user_id', $auth_id)->get();
        $subtotals = $this->subtotals($carts);
        $totals = $this->totals($carts);
        $key = config('app.stripe_api');
        return view('cart.confirm', compact('carts', 'totals', 'subtotals','key'));
    }

    
    public function send(){
        $carts = Cart::where('user_id',Auth::id())->get();
        $subtotals = $this->subtotals($carts);
        $totals = $this->totals($carts);
        $user = User::where('id',Auth::id())->first();
        Mail::send(new NotifyCompleted($carts,$subtotals,$totals,$user));
        Cart::where('user_id', Auth::id())->delete();
        return redirect('/cart/complete');
    }

    public function payment(Request $request)
    {
        try
        {
            Stripe::setApiKey(config('app.stripe_secret'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            $carts = Cart::where('user_id',Auth::id())->get();
            $subtotals = $this->subtotals($carts);
            $totals = $this->totals($carts);

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => $totals,
                'currency' => 'jpy'
            ));

            return redirect('/mail');
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }


}
