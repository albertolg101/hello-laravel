<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Poll;
use App\Rules\OnlyOneWithValueOnPath;
use App\Rules\PathReducer;
use App\Rules\InArray;
use App\Rules\UniqueInPath;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PollController extends Controller
{
    public function index()
    {
        $pollController = new Api\PollController();
        $polls = $pollController->index()->getData();
        return view('user.polls.index', compact('polls'));
    }

    public function show(int $id)
    {
        $pollController = new Api\PollController();
        $poll = $pollController->show($id)->getData();
        return view('user.polls.show', compact('poll'));
    }

    public function create()
    {
        $languages = Language::all();
        $pollData = [
            'id' => null,
            'translations' => self::getOldData()
        ];
        return view('user.polls.create', compact('languages', 'pollData'));
    }

    public function store(Request $request)
    {
        $pollController = new Api\PollController();
        $poll = $pollController->store($request)->getData();
        return redirect()->route('polls.show', ['poll' => $poll->id]);
    }

    public function edit(int $id)
    {
        $poll = Poll::findOrFail($id);

        $languages = Language::all();
        $pollData = [
            'id' => $poll->id,
            'translations' => self::getOldData()
        ];

        if ($pollData['translations'] === null) {
            $poll->load(
                'question.translations',
                'options.translations',
            );

            $pollData['translations'] = [];

            for($i = 0; $i < $poll->question->translations->count(); $i++) {
                $pollData['translations'][$i] = [
                    'question' => [
                        'id' => $poll->question->translations[$i]->id,
                        'value' => $poll->question->translations[$i]->content,
                    ],
                    'options' => $poll->options->map(function ($option) use ($i) {
                        return [
                            'id' => $option->translations[$i]->id,
                            'value' => $option->translations[$i]->content,
                        ];
                    })->toArray(),
                    'language' => $poll->question->translations[$i]->language_id,
                    'is_default' => $poll->question->translations[$i]->is_default === 1,
                ];
            }
        }

        return view('user.polls.edit', compact('pollData', 'languages'));
    }

    public function update(Request $request, int $id)
    {
        $pollController = new Api\PollController();
        $poll = $pollController->update($request, $id)->getData();
        return redirect()->route('polls.show', ['poll' => $poll->id]);
    }

    public function destroy(Request $request, int $id)
    {
        $pollController = new Api\PollController();
        $pollController->destroy($request, $id);
        return redirect()->route('polls.index');
    }

    // Custom methods
    public static function getOldData()
    {

        if (old('data') === null) {
            return null;
        } else {
            $oldData = old('data');
            foreach ($oldData as $i => $translation) {
                $oldData[$i]['is_default'] = ($translation['is_default'] ?? "off") === 'on';
            }
            return $oldData;
        }
    }
}
