<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'classes',
        'content',
        'size',
    ];

    /**
     * Save translated slug to model
     *
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['title'])
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }

    public function getContentAttribute()
    {
        return json_decode($this->attributes['content']);
    }
}
