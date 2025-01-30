<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\LocalizedText;
use App\Models\Poll;
use App\Models\PollQuestion;
use App\Rules\OnlyOneWithValueOnPath;
use App\Rules\PathReducer;
use App\Rules\InArray;
use App\Rules\UniqueInPath;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Route;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::orderBy('id')->get();
        $polls->load([
            'question.translations',
            'options.translations',
        ]);
        $language = Language::first();

        return view('user.polls.index', compact('polls', 'language'));
    }

    public function show(int $id)
    {
        $poll = Poll::findOrFail($id);

        $language = Language::first();
        $prevPollId = Poll::where('id', '<', $id)->orderBy('id', 'desc')->first()?->id;
        $nextPollId = Poll::where('id', '>', $id)->orderBy('id')->first()?->id;

        return view('user.polls.show', compact('poll', 'language', 'prevPollId', 'nextPollId'));
    }

    public function create()
    {
        $languages = Language::all();
        return view('user.polls.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => [
                'required', 'array',
                new UniqueInPath('*.language'),
                new OnlyOneWithValueOnPath('*.is_default', 'on')
            ],
            'data.*.language' => ['required', 'int', 'exists:languages,id'],
            'data.*.question.value' => ['required', 'string', 'max:255'],
            'data.*.options' => ['required', 'array', 'min:2', 'max:2'],
            'data.*.options.*.value' => ['required', 'string', 'max:255'],
        ]);

        $poll = Poll::create();

        $question = $poll->question()->create();
        $options = [
            $poll->options()->create(),
            $poll->options()->create(),
        ];
        foreach ($request->input('data') as $data) {
            $is_default = array_key_exists('is_default', $data) && $data['is_default'] === 'on' ? true : null;

            $question->translations()->create([
                'content' => $data['question']['value'],
                'language_id' => $data['language'],
                'is_default' => $is_default,
            ]);

            for ($i = 0; $i < count($data['options']); $i++) {
                $options[$i]->translations()->create([
                    'content' => $data['options'][$i]['value'],
                    'language_id' => $data['language'],
                    'is_default' => $is_default,
                ]);
            }
        }

        return redirect()->route('polls.show', ['poll' => $poll->id]);
    }

    public function edit(int $id)
    {
        $poll = Poll::findOrFail($id);

        $languages = Language::all();
        $pollData = [
            'id' => $poll->id,
            'translations' => []
        ];

        $poll->load(
            'question.translations',
            'options.translations',
        );

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

        return view('user.polls.edit', compact('pollData', 'languages'));
    }

    public function update(Request $request, int $id)
    {
        $poll = Poll::findOrFail($id);

        $poll->load(
            'question.translations',
            'options.translations',
        );

        $question = $poll->question;
        $options = $poll->options;
        $question_translations_ids = $question->translations->pluck('id')->toArray();
        $options_translations_ids = $options->map(fn($option) => $option->translations->pluck('id')->toArray());

        $request->validate([
            'data' => [
                'required', 'array',
                new UniqueInPath('*.language'),
                new UniqueInPath('*.question.id'),
                new UniqueInPath('*.options.*.id'),
                new InArray('*.question.id', $question_translations_ids),
                new InArray('*.options.0.id', $options_translations_ids[0]),
                new InArray('*.options.1.id', $options_translations_ids[1]),
                new OnlyOneWithValueOnPath('*.is_default', 'on')
            ],
            'data.*.language' => ['required', 'int', 'exists:languages,id'],
            'data.*.question.id' => ['nullable', 'int'],
            'data.*.question.value' => ['required', 'string', 'max:255'],
            'data.*.options' => ['required', 'array', 'min:2', 'max:2'],
            'data.*.options.*.id' => ['nullable', 'int'],
            'data.*.options.*.value' => ['required', 'string', 'max:255'],
        ]);

        $question->translations()
            ->whereNotIn(
                'id',
                PathReducer::reduce('*.question.id', $request->input('data'), true))
            ->delete();

        for($i = 0; $i < count($options); $i++) {
            $options[$i]->translations()
                ->whereNotIn(
                    'id',
                    PathReducer::reduce('*.options.'.$i.'.id', $request->input('data'), true))
                ->delete();
        }

        foreach ($request->input('data') as $data) {
            $is_default = array_key_exists('is_default', $data) && $data['is_default'] === 'on' ? true : null;

            if (is_null($data['question']['id'])) {
                $question
                    ->translations()
                    ->create([
                        'content' => $data['question']['value'],
                        'language_id' => $data['language'],
                        'is_default' => $is_default,
                    ]);
            } else {
                $question
                    ->translations()
                    ->find($data['question']['id'])
                    ->update([
                        'content' => $data['question']['value'],
                        'language_id' => $data['language'],
                        'is_default' => $is_default,
                    ]);
            }

            for ($i = 0; $i < count($data['options']); $i++) {
                if (is_null($data['options'][$i]['id'])) {
                    $options[$i]->translations()
                        ->create([
                            'content' => $data['options'][$i]['value'],
                            'language_id' => $data['language'],
                            'is_default' => $is_default,
                        ]);
                } else {
                    $options[$i]->translations()
                        ->find($data['options'][$i]['id'])
                        ->update([
                            'content' => $data['options'][$i]['value'],
                            'language_id' => $data['language'],
                            'is_default' => $is_default,
                        ]);
                }
            }
        }

        return redirect()->route('polls.show', ['poll' => $poll->id]);
    }

    public function destroy(Request $request, int $id)
    {
        $poll = Poll::findOrFail($id);

        $poll->delete();

        $redirectTo = $request->query->get('redirectTo');
        if ($redirectTo !== null) {
            return redirect($redirectTo);
        }

        return redirect()->route('polls.index');
    }
}
