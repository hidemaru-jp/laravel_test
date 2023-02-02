<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;

    use SoftDeletes; //ソフトデリート準備
    protected $fillable = ['user_id', 'item_id', 'quantity'];
    protected $table = 'carts';

    public function item() {
        //リレーション
        return $this->belongsTo('App\Models\Item', 'item_id');
    }

    public function insert($item_id, $add_qty) {
        $item = (new item)->findOrFail($item_id);
        $qty = $item->quantity;
        //在庫なしバリデーション
        if ($qty <= 0) {
            return false;
        }
        $cart = $this->firstOrCreate(['user_id' => Auth::id(), 'item_id' => $item_id], ['quantity' => 0]);
        DB::beginTransaction();
        try {
            $cart->increment('quantity', $add_qty);
            $item->decrement('quantity', $add_qty);
            DB::commit();
            return true;
        } catch (Exception) {
            DB::rollback();
            return false;
        }
    }
    public function subtotal() {
        $result = $this->item->price * $this->quantity;
        return $result;
    }
    
}
