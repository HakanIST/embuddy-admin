<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $table = 'Guide';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'summary',
        'content',
        'categoryId',
        'readTimeMinutes',
        'isMandatory',
        'icon',
        'createdAt',
    ];

    protected $casts = [
        'isMandatory' => 'boolean',
        'readTimeMinutes' => 'integer',
        'createdAt' => 'datetime',
        'content' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(GuideCategory::class, 'categoryId');
    }
}
