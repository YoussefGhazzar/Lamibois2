<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'space',
        'format',
        'finition',
        'description',
        'norm',
        'price',
        'image',
        "category",
        "norm"
    ];
    
}
