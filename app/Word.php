<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['title', 'description', 'is_published', 'image'];

    protected $dates = ['created_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Word $word) {
            if($word->is_published === null) {
                $word->is_published = false;
            }
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function validations()
    {
        return [
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'nullable|image'
        ];
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('Y.m.d');
    }

    public function getImageAttribute($image)
    {
        if($image) {
            return 'storage/'. $image;
        }
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->where(['is_published' => true]);
    }
}
