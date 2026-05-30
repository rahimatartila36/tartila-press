<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookChapter extends Model
{
    protected $fillable = [
        'cover',
        'title',
        'package_id',
        'category',
        'field',
        'description',
        'estimated_publish',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function items()
    {
        return $this->hasMany(BookChapterItem::class);
    }
}