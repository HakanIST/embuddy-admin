<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
    ];

    /**
     * Content accessor/mutator: converts between flat API format and Filament Builder format.
     *
     * API/DB format:  [{type: "heading", text: "...", level: 1}, ...]
     * Builder format: [{type: "heading", data: {text: "...", level: 1}}, ...]
     */
    protected function content(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $sections = is_string($value) ? json_decode($value, true) : $value;
                if (!is_array($sections)) return [];

                // If already in Builder format (has 'data' key), return as-is
                if (!empty($sections) && isset($sections[0]['data'])) {
                    return $sections;
                }

                // Convert flat API format → Builder format
                return array_map(function ($section) {
                    $type = $section['type'] ?? 'paragraph';
                    $data = $section;
                    unset($data['type']);
                    return ['type' => $type, 'data' => $data];
                }, $sections);
            },
            set: function ($value) {
                if (!is_array($value)) return $value;

                // Convert Builder format → flat API format for storage
                $flat = array_values(array_map(function ($block) {
                    if (isset($block['data']) && isset($block['type'])) {
                        return array_merge(['type' => $block['type']], $block['data']);
                    }
                    return $block;
                }, $value));

                return json_encode($flat);
            },
        );
    }

    public function category()
    {
        return $this->belongsTo(GuideCategory::class, 'categoryId');
    }
}
