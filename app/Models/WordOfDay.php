<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordOfDay extends Model
{
    protected $table = 'WordOfDay';
    public $timestamps = false;

    protected $fillable = [
        'turkishWord',
        'pronunciation',
        'englishTranslation',
        'definition',
        'date',
        'xpReward',
    ];

    protected $casts = [
        'xpReward' => 'integer',
    ];
}
