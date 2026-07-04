<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'Feedback';
    public $timestamps = false;

    protected $fillable = [
        'userId',
        'subject',
        'message',
        'createdAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(EmbuddyUser::class, 'userId');
    }
}
