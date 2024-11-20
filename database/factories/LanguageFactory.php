<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $language_code = fake()->unique()->languageCode();
        $english_name = locale_get_display_language($language_code, 'en');

        return [
            'code' => $language_code,
            'english_name' => $english_name,
        ];
    }
}
