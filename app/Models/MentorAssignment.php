<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorAssignment extends Model
{
    protected $table = 'MentorAssignment';
    public $timestamps = false;

    protected $fillable = [
        'mentorId',
        'menteeId',
        'status',
        'assignedAt',
    ];

    protected $casts = [
        'assignedAt' => 'datetime',
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentorId');
    }

    public function mentee()
    {
        return $this->belongsTo(EmbuddyUser::class, 'menteeId');
    }

    public function messages()
    {
        return $this->hasMany(MentorMessage::class, 'assignmentId');
    }
}
