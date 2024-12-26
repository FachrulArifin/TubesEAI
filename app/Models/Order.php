<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    protected $fillable = ['name', 'email', 'address', 'phone', 'total_price', 'status'];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_product')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
