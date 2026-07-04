<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodEntry extends Model
{
    protected $table = 'MoodEntry';
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'mood',
        'note',
        'createdAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(EmbuddyUser::class, 'userId');
    }
}
