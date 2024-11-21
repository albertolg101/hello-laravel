<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['code' => 'en', 'english_name' => 'English'],
            ['code' => 'es', 'english_name' => 'Spanish'],
            ['code' => 'fr', 'english_name' => 'French'],
            ['code' => 'pt', 'english_name' => 'Portuguese'],
            ['code' => 'ru', 'english_name' => 'Russian'],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
