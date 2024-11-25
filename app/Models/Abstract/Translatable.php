<?php

namespace App\Models\Abstract;

use Illuminate\Database\Eloquent\Model;
use App\Models\Translations;

abstract class Translatable extends Model
{
    public function getDefaultText()
    {
//        return $this->translations()->first()->defaultLocalizedText()->first()->content;
        return $this->translations->defaultLocalizedText->content;
    }
    public function text(int $languageId = null)
    {
        if ($languageId !== null) {
            $localizedText = $this
                ->translations
                ->localizedTexts->where('language_id', $languageId)->first();


            if ($localizedText !== null) {
                return $localizedText->content;
            }
        }

        return $this->getDefaultText();
    }

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
