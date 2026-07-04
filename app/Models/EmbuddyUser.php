<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmbuddyUser extends Model
{
    protected $table = 'User';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'fullName',
        'hashedPassword',
        'department',
        'country',
        'year',
        'avatarUrl',
        'language',
        'xpPoints',
        'level',
        'isActive',
    ];

    protected $casts = [
        'isActive' => 'boolean',
        'createdAt' => 'datetime',
        'xpPoints' => 'integer',
        'level' => 'integer',
        'year' => 'integer',
    ];

    public function moodEntries()
    {
        return $this->hasMany(MoodEntry::class, 'userId');
    }

    public function streak()
    {
        return $this->hasOne(Streak::class, 'userId');
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'UserAchievement', 'userId', 'achievementId')
            ->withPivot('earnedAt');
    }

    public function taskCompletions()
    {
        return $this->hasMany(UserTaskCompletion::class, 'userId');
    }
}
