<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['name', 'image', 'price', 'stock', 'description', 'category'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
