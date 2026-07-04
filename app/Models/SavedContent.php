<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedContent extends Model
{
    protected $table = 'SavedContent';
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'contentType',
        'contentId',
        'savedAt',
    ];

    protected $casts = [
        'savedAt' => 'datetime',
        'contentId' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(EmbuddyUser::class, 'userId');
    }
}
