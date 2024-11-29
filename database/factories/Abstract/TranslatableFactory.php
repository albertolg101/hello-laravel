<?php

namespace Database\Factories\Abstract;

use App\Models\Language;
use App\Models\LocalizedText;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abstract\Translatable;

abstract class TranslatableFactory extends Factory
{
    public function withTranslation(
        Collection   $languages,
        Language     $defaultLanguage,
        bool         $asWord = false
    )
    {
        return $this->afterCreating(function (Translatable $translatable) use ($languages, $defaultLanguage, $asWord) {
            $this->addTranslation($translatable, $languages, $defaultLanguage, $asWord);
        });
    }

    public static function addTranslation(
        Translatable $translatable,
        Collection   $languages,
        Language     $defaultLanguage,
        bool         $asWord = false
    )
    {
        $count = $languages->count();

        $localizedText = LocalizedText::factory()
            ->count($count)
            ->withContentAsWord($asWord)
            ->sequence(fn ($sequence) => ['language_id' => $languages[$sequence->index]->id])
            ->create([
                'translatable_id' => $translatable->id,
                'translatable_type' => $translatable->getMorphClass(),
            ]);

        $localizedText
            ->where('language_id', $defaultLanguage->id)
            ->first()
            ->update(['is_default' => true]);
    }
}
