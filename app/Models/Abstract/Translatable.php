<?php

namespace App\Models\Abstract;

use App\Models\LocalizedText;
use Illuminate\Database\Eloquent\Model;
use App\Models\Translations;

abstract class Translatable extends Model
{
    public function translations()
    {
        return $this->morphMany(LocalizedText::class, 'translatable');
    }

    public function defaultTranslation()
    {
        $defaultTranslation =  $this->translations->where('is_default', true)->first();
        if ($defaultTranslation === null) {
            $defaultTranslation = $this->translations->sortBy('id')->first();
        }

        return $defaultTranslation;
    }

    public function translation(string $languageId)
    {
        return $this->translations->where('language_id', $languageId)->first();
    }

    public function translationOrDefault(string $languageId)
    {
        $translation = $this->translation($languageId);
        if ($translation === null) {
            $translation = $this->defaultTranslation();
        }

        return $translation;
    }

    protected static function booted()
    {
        static::deleting(function ($translatable) {
            $translatable->translations()->delete();
        });
    }
}
