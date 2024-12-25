<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded =[];

    protected $fillable = ['total_price', 'status', 'quantities', 'prices'];

    protected $casts = [
        'quantities' => 'array', // Pastikan data dikonversi menjadi array
        'prices' => 'array',
    ];
}
