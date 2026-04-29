<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [

    'name',
    'category',
    'price',
    'description',
    'is_active',
    'image',
    'discount'

];
}