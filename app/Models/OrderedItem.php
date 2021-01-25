<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedItem extends Model
{
    use HasFactory;
    protected $fillable = ['item_id','order_id', 'quantity'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
  
}
