<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorMessage extends Model
{
    protected $table = 'MentorMessage';
    public $timestamps = false;

    protected $fillable = [
        'assignmentId',
        'senderId',
        'message',
        'isRead',
        'createdAt',
    ];

    protected $casts = [
        'isRead' => 'boolean',
        'createdAt' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(MentorAssignment::class, 'assignmentId');
    }

    public function sender()
    {
        return $this->belongsTo(EmbuddyUser::class, 'senderId');
    }
}
