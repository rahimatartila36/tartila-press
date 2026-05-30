<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Royalty extends Model
{
    protected $fillable = [
        'user_id',
        'book_title',
        'sold_qty',
        'total_sales',
        'royalty_percent',
        'royalty_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}