<?php

use App\Models\Poll;

test('play page is shown', function () {
    $language_seeder = new \Database\Seeders\LanguageSeeder();
    $language_seeder->run();
    $poll = Poll::factory()->withOptions(2)->create();
    $poll->load('question.translations', 'options.translations');
    $language_id = $poll->question->translations->first()->language_id;
    session([ 'language_id' => $language_id ]);

    $response = $this->get('/');
    $response->assertSeeInOrder([
        // First time it appears in html tags
        $poll->question->translationOrDefault($language_id)->content,
        $poll->options[0]->translationOrDefault($language_id)->content,
        $poll->options[1]->translationOrDefault($language_id)->content,

        // Second time it appears in javascript
        $poll->question->translationOrDefault($language_id)->content,
        $poll->options[0]->translationOrDefault($language_id)->content,
        $poll->options[1]->translationOrDefault($language_id)->content,
    ]);
});
