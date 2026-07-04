<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    protected $table = 'DailyTask';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'xpReward',
        'taskType',
        'isRecurring',
    ];

    protected $casts = [
        'xpReward' => 'integer',
        'isRecurring' => 'boolean',
    ];

    public function completions()
    {
        return $this->hasMany(UserTaskCompletion::class, 'taskId');
    }
}
