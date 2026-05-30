<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublishingSubmission extends Model
{
    protected $fillable = [
        'payment_id',
        'user_id',
        'package_id',
        'book_title',
        'manuscript_file',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function authors()
    {
        return $this->hasMany(PublishingAuthor::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}