<?php

namespace App\Models\Abstract;

use App\Models\LocalizedText;
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
        if ($language === null) {
            $language = $this->translations->localizedTexts->first();
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

    public function addLocalizableText(
        string       $text,
        int          $languageId,
        bool         $setAsDefault = false,
    )
    {
        $translations = $this->translations()->firstOrCreate();
        $localizedText = $translations->localizedTexts()->create([
            'content' => $text,
            'language_id' => $languageId,
            'translations_id' => $translations->id,
        ]);

        if ($setAsDefault) {
            $translations->update(['default_localized_text_id' => $localizedText->id]);
        }
    }

    protected static function booted()
    {
        static::deleting(function ($translatable) {
            $translatable->translations()->delete();
        });
    }
}
