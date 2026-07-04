<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $table = 'Mentor';
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'bio',
        'languages',
        'maxMentees',
        'isActive',
        'createdAt',
    ];

    protected $casts = [
        'isActive' => 'boolean',
        'maxMentees' => 'integer',
        'createdAt' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(EmbuddyUser::class, 'userId');
    }

    public function assignments()
    {
        return $this->hasMany(MentorAssignment::class, 'mentorId');
    }

    public function activeAssignments()
    {
        return $this->hasMany(MentorAssignment::class, 'mentorId')->where('status', 'active');
    }
}
