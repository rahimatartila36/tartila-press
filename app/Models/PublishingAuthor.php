<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublishingAuthor extends Model
{
    protected $fillable = [
        'publishing_submission_id',
        'name',
        'phone',
        'nik',
        'address',
        'email',
        'order',
    ];

    public function submission()
    {
        return $this->belongsTo(PublishingSubmission::class, 'publishing_submission_id');
    }
}