<?php

namespace App\Http\Controllers;
use App\Mail\NotifyCompleted;
use App\Http\Controllers\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSendController extends Controller
{
    public function send(){
        $cart = Cart::where('user_id',Auth::id())->get();
        $subtotals = $this->subtotals($carts);
        $totals = $this->totals($carts);
        Mail::send(new NotifyCompleted());
        return redirect('/cart/complete');
        }
}
