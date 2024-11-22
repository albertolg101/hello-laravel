<?php

namespace Database\Factories\Abstract;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Translations;
use App\Models\Abstract\Translatable;

abstract class TranslatableFactory extends Factory
{
    public function withTranslation(int $count=1)
    {
        return $this->afterCreating(function (Translatable $translatable) use ($count) {
            $this->addTranslation($translatable, $count);
        });
    }

    public static function addTranslation(Translatable $translatable, int $count=1)
    {
        $translatable->translations()->create();
        Translations::factory()->addLocalizedText($translatable->translations, $count, true);
    }
}
