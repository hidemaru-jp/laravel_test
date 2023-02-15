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

    public function subtotal() {
        $result = $this->item->price * $this->quantity;
        return $result;
    }
    
}
