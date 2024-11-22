<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PollOption;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PollVote>
 */
class PollVoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'poll_option_id' => PollOption::inRandomOrder()->first()->id,
        ];
    }
}
