<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Poll;
use App\Models\PollQuestion;
use App\Models\PollOption;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
{
    protected static $languages;

    public function __construct(
        $count = null,
        ?Collection $states = null,
        ?Collection $has = null,
        ?Collection $for = null,
        ?Collection $afterMaking = null,
        ?Collection $afterCreating = null,
        $connection = null,
        ?Collection $recycle = null)
    {
        if (is_null(self::$languages)) {
            self::$languages = Language::inRandomOrder()->limit(3)->get();
        }
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);
    }

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
            PollQuestion::factory()
                ->withTranslation(self::$languages, self::$languages[0])
                ->create(['poll_id' => $poll->id]);
        });
    }

    public function withOptions(int $count = 2)
    {
        return $this->afterCreating(function (Poll $poll) use ($count) {
            PollOption::factory()
                ->count($count)
                ->withTranslation(self::$languages, self::$languages[0])
                ->create(['poll_id' => $poll->id]);
        });
    }
}
