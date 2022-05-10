<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Department;

class Category extends Model
{
    use HasFactory;

    protected $table= 'categories';

    protected $fillable = [
        'department_id',
    ];

    public function items(){
        return $this->hasMany(Item::class , 'category_id' , 'id');
    }

    public function departments(){
        return $this->belongsTo(Department::class , 'department_id' , 'id');
    }
}
