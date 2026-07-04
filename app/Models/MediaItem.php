<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    protected $table = 'MediaItem';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'mediaType',
        'creator',
        'episode',
        'durationMinutes',
        'thumbnailUrl',
        'mediaUrl',
    ];

    protected $casts = [
        'episode' => 'integer',
        'durationMinutes' => 'integer',
    ];
}
