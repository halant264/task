<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Itemsr;

class Order_details extends Model
{
    use HasFactory;

    protected $table= 'order_details';


       protected $fillable = [
        'order_id',
        'item_id ',
        'total_price',
        'count',
        'is_fired',
        'status',
        'notes',
        'note_price',
        'delay',
        'cost',
    ];

    public function items(){
        return $this->belongsTo(Itemsr::class , 'item_id' , 'id' );
    }
}
