<?php

namespace App\Models\Abstract;

use Illuminate\Database\Eloquent\Model;
use App\Models\Translations;

abstract class Translatable extends Model
{
    public function translationOrDefault(int $languageId = null)
    {
        $language = $this->translation($languageId);
        if ($language === null) {
            $language = $this->translations->defaultLocalizedText;
        }

        return $language;
    }

    public function translation(int $languageId = null)
    {
        if ($languageId === null) {
            return null;
        }

        return $this->translations->localizedTexts->where('language_id', $languageId)->first();
    }

    public function translations()
    {
        return $this->morphOne(Translations::class, 'translatable');
    }

    protected static function booted()
    {
        static::deleting(function ($translatable) {
            $translatable->translations()->delete();
        });
    }
}
