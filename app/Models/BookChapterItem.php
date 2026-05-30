<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookChapterItem extends Model
{
    protected $fillable = [
        'book_chapter_id',
        'chapter_title',
        'price',
        'discount',
        'status',
    ];

    public function bookChapter()
    {
        return $this->belongsTo(BookChapter::class);
    }

    public function getEffectivePriceAttribute()
    {
        return $this->price ?? optional($this->bookChapter->package)->price ?? 0;
    }

    public function getEffectiveDiscountAttribute()
    {
        return $this->discount ?? optional($this->bookChapter->package)->discount ?? 0;
    }

    public function getFinalPriceAttribute()
    {
        $price = $this->effective_price;
        $discount = $this->effective_discount;

        return $price - ($price * $discount / 100);
    }
}