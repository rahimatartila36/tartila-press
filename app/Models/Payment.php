<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [

        'package_id',
        'name',
        'phone',
        'proof',
        'status'

    ];
}