<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAttendee extends Model
{
    protected $table = 'EventAttendee';
    public $timestamps = false;

    protected $fillable = [
        'eventId',
        'userId',
        'createdAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'eventId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
