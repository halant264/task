<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table= 'items';

    public function categories(){
        return $this->belongsTo(Category::class , 'category_id' , 'id' );
    }


    public function order_detailss(){
        return $this->hasMany(Order_details::class , 'item_id' , 'id' );
    }
}
