<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Translations;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function withTranslation(int $count=1)
    {
        return $this->afterCreating(function (Category $category) use ($count) {
            $this->addTranslation($category, $count);
        });
    }

    public static function addTranslation(Category $category, int $count=1)
    {
        $category->translations()->create();
        Translations::factory()->addLocalizedText($category->translations, $count, true);
    }
}
