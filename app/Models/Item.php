<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','image_url','description', 'price'];

    public function ordereditem()
    {
        return $this->hasMany(OrderedItem::class);
        
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

   
}
