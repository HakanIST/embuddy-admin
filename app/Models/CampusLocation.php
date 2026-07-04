<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampusLocation extends Model
{
    protected $table = 'CampusLocation';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'campus',
        'building',
        'floor',
        'schedule',
        'category',
        'latitude',
        'longitude',
        'hasWheelchairAccess',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'hasWheelchairAccess' => 'boolean',
    ];
}
