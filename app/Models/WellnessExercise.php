<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WellnessExercise extends Model
{
    protected $table = 'WellnessExercise';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'category',
        'description',
        'durationSeconds',
        'steps',
        'icon',
        'isActive',
        'sortOrder',
    ];

    protected $casts = [
        'durationSeconds' => 'integer',
        'isActive' => 'boolean',
        'sortOrder' => 'integer',
    ];
}
