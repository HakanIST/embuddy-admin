<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideCategory extends Model
{
    protected $table = 'GuideCategory';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'icon',
        'color',
        'articleCount',
    ];

    protected $casts = [
        'articleCount' => 'integer',
    ];

    public function guides()
    {
        return $this->hasMany(Guide::class, 'categoryId');
    }
}
