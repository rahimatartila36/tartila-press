<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
    'user_id',
    'title',
    'author',
    'year',
    'description',
    'cover',
    'isbn',
    'editor',
    'penyunting',
    'desain',
    'penerbit',
    'kategori',
    'keilmuan',
    'tahun_terbit',
    'harga',
    'diskon',
];

public function user()
{
    return $this->belongsTo(User::class);
}

}