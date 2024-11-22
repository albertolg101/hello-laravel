<?php

namespace App\Models\Abstract;

use Illuminate\Database\Eloquent\Model;
use App\Models\Translations;

abstract class Translatable extends Model
{
    public function translations()
    {
        return $this->morphOne(Translations::class, 'translatable');
    }

    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->translations()->delete();
        });
    }
}
