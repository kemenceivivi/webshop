<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'address', 'comment', 'payment_method','status','received_on','processed_on'];

    public function ordereditems()
    {
        return $this->hasMany(OrderedItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
