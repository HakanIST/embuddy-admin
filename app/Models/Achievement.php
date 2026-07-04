<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'Achievement';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'xpReward',
        'conditionType',
        'conditionValue',
    ];

    protected $casts = [
        'xpReward' => 'integer',
        'conditionValue' => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(EmbuddyUser::class, 'UserAchievement', 'achievementId', 'userId')
            ->withPivot('earnedAt');
    }
}
