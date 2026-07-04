<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTaskCompletion extends Model
{
    protected $table = 'UserTaskCompletion';
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'taskId',
        'completedAt',
        'date',
    ];

    protected $casts = [
        'completedAt' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(EmbuddyUser::class, 'userId');
    }

    public function task()
    {
        return $this->belongsTo(DailyTask::class, 'taskId');
    }
}
