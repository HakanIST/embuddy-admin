<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    protected $table = 'Streak';
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'currentStreak',
        'longestStreak',
        'lastCheckinDate',
    ];

    protected $casts = [
        'currentStreak' => 'integer',
        'longestStreak' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(EmbuddyUser::class, 'userId');
    }
}
