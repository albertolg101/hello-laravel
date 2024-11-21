<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Translatable;

class TranslatableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Translatable::factory()->count(2)->withLocalizedText(1)->create();
        Translatable::factory()->count(2)->withLocalizedText(2)->create();
        Translatable::factory()->count(2)->withLocalizedText(3)->create();
    }
}
