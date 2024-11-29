<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\LocalizedText;
use App\Models\Poll;
use App\Models\PollQuestion;
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

        return view('user.polls.show', [
            'poll' => $poll,
            'language' => $language,
            'prevPollId' => $prevPollId,
            'nextPollId' => $nextPollId,
        ]);
    }

    public function create()
    {
        $languages = Language::all();
        return view('user.polls.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => ['required', 'array', new UniqueInPath('*.language')],
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
            $question->translations()->create([
                'content' => $data['question']['value'],
                'language_id' => $data['language'],
            ]);

            for ($i = 0; $i < count($data['options']); $i++) {
                $options[$i]->translations()->create([
                    'content' => $data['options'][$i]['value'],
                    'language_id' => $data['language'],
                ]);
            }
        }

        return redirect()->route('user.poll.show', ['id' => $poll->id]);
    }

    public function edit(int $id)
    {
        $poll = Poll::findOrFail($id);

        $languages = Language::all();
        $poll->load(
            'question.translations',
            'options.translations',
        );

        return view('user.polls.edit', compact('poll', 'languages'));
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
            if (is_null($data['question']['id'])) {
                $question
                    ->translations()
                    ->create([
                        'content' => $data['question']['value'],
                        'language_id' => $data['language'],
                    ]);
            } else {
                $question
                    ->translations()
                    ->find($data['question']['id'])
                    ->update([
                        'content' => $data['question']['value'],
                        'language_id' => $data['language'],
                    ]);
            }

            for ($i = 0; $i < count($data['options']); $i++) {
                if (is_null($data['options'][$i]['id'])) {
                    $options[$i]->translations()
                        ->create([
                            'content' => $data['options'][$i]['value'],
                            'language_id' => $data['language'],
                        ]);
                } else {
                    $options[$i]->translations()
                        ->find($data['options'][$i]['id'])
                        ->update([
                            'content' => $data['options'][$i]['value'],
                            'language_id' => $data['language'],
                        ]);
                }
            }
        }

        return redirect()->route('user.poll.show', ['id' => $poll->id]);
    }

    public function destroy(Request $request, int $id)
    {
        $poll = Poll::findOrFail($id);

        $poll->delete();

        $redirectTo = $request->query->get('redirectTo');
        if ($redirectTo !== null) {
            return redirect($redirectTo);
        }

        return redirect()->route('user.poll.index');
    }
}
