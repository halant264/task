<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order_details;


class Order extends Model
{
    use HasFactory;

    // protected $table= 'orders';


    private $consumption_taxs = 0.1;
    private $rebuild_tax  = 0.05;
    private $local_adminstration  = 0.01;
    private $taxes  = 0.1;
    private $total_after_taxes  ;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'table_id',
        'order_date',
        'total_price',
        'payment_state',
        'payment_method',
        'client_id',
        'status',
        'customer',
        'user_id',
        'total_cost',
        'discount_amount',
        'taxes',
        'consumption_taxs',
        'local_adminstration',
        'rebuild_tax',
        'notes',
        'client_name',
    ];

    public function settotal_priceAttribute($value)
    {
        $this->attributes['total_price'] =  Order_details::where('order_id' , $value)->sum('total_price');
    }


    public function setconsumption_taxsAttribute()
    {
        $this->attributes['consumption_taxs'] = $this->total_price * $this->consumption_taxs;
    }
    public function setrebuild_taxAttribute()
    {
        $this->attributes['rebuild_tax'] = $this->total_price * $this->rebuild_tax;
    }
    public function setlocal_adminstrationAttribute()
    {
        $this->attributes['local_adminstration'] = $this->total_price * $this->local_adminstration;
    }
    public function settaxesAttribute()
    {
        $this->attributes['taxes'] = $this->taxes;
    }
    public function settotal_after_taxesAttribute()
    {
        $this->attributes['total_after_taxes'] = $this->total_price + $this->taxes;
    }
    
}
