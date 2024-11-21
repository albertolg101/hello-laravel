<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Language;
use App\Models\LocalizedText;
use App\Models\Translatable;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translatable>
 */
class TranslatableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        ];
    }

    public function withLocalizedText(int $count = 1)
    {
        return $this->afterCreating(function (Translatable $translatable) use ($count) {
            $this->addLocalizedText($translatable, $count);
        });
    }

    public static function addLocalizedText(Translatable $translatable, int $count = 1)
    {
        $language_ids = Language::inRandomOrder()->limit($count)->pluck('id')->all();
        $localizedTexts = LocalizedText::factory()
            ->count($count)
            ->sequence(fn($sequence) => ['language_id' => $language_ids[$sequence->index]])
            ->state(['translatable_id' => $translatable->id])
            ->create();
        $translatable->update(['default_localized_text_id' => $localizedTexts->first()->id]);
    }
}
