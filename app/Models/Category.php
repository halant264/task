<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Itemsr;
use App\Models\Department;

class Category extends Model
{
    use HasFactory;

    protected $table= 'categories';

    protected $fillable = [
        'department_id',
        // 'item_id ',
        // 'total_price',
        // 'count',
        // 'is_fired',
        // 'status',
        // 'notes',
        // 'note_price',
        // 'delay',
        // 'cost',
    ];

    public function items(){
        return $this->hasMany(Itemsr::class , 'category_id' , 'id');
    }

    public function departments(){
        return $this->belongsTo(Department::class , 'department_id' , 'id');
    }
}
