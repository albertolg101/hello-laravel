<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function translations()
    {
        return $this->morphOne(Translatable::class, 'translatable');
    }

    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->translations()->delete();
        });
    }
}
