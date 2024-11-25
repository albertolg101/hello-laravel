<?php

namespace Database\Factories\Abstract;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Translations;
use App\Models\Abstract\Translatable;

abstract class TranslatableFactory extends Factory
{
    public function withTranslation(int $count = 1, bool $asWord = false)
    {
        return $this->afterCreating(function (Translatable $translatable) use ($count, $asWord) {
            $this->addTranslation($translatable, $count, $asWord);
        });
    }

    public static function addTranslation(Translatable $translatable, int $count = 1, bool $asWord = false)
    {
        $translatable->translations()->create();
        Translations::factory()->addLocalizedText($translatable->translations, $count, $asWord);
    }
}
