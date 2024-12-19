<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function users()
    {
        return $this->belongsToMany(User::class, 'product_user')->withPivot('quantity')->withTimestamps();
    }
}
