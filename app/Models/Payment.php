<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
    'package_id',
    'book_id',
    'order_id',
    'type',
    'name',
    'phone',
    'proof',
    'status',
    'book_chapter_item_id'
];

    public function package()
    {
         return $this->belongsTo(Package::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
   public function bookChapterItem()
{
    return $this->belongsTo(BookChapterItem::class);
}
}