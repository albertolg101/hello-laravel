<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Poll;
use App\Models\PollQuestion;
use App\Models\PollOption;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
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

    public function configure()
    {
        return $this->afterCreating(function (Poll $poll) {
            PollQuestion::factory()->withTranslation(2)->create(['poll_id' => $poll->id]);
        });
    }

    public function withOptions(int $count = 2)
    {
        return $this->afterCreating(function (Poll $poll) use ($count) {
            PollOption::factory()->count($count)->withTranslation(2)->create(['poll_id' => $poll->id]);
        });
    }
}
