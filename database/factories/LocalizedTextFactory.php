<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Language;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LocalizedText>
 */
class LocalizedTextFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $language = Language::inRandomOrder()->first();

        return [
            'content' => $this->faker->text(),
            'language_id' => $language
        ];
    }

    public function withContentAsWord(bool $asWord = true)
    {
        return $asWord ? $this->state(fn () => ['content' => $this->faker->word]) : $this;
    }
}
