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
            'question.translations.localizedTexts',
            'question.translations.defaultLocalizedText',
            'options.translations.localizedTexts',
            'options.translations.defaultLocalizedText',
        ]);
        $language = Language::first();

        return view('user.polls.index', [
            'polls' => $polls,
            'language' => $language,
        ]);
    }

    public function show(int $id)
    {
        $poll = Poll::find($id);

        if ($poll === null) {
            abort(404);
        }

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
            $question->addLocalizableText(
                $data['question']['value'],
                $data['language'],
            );

            for ($i = 0; $i < count($data['options']); $i++) {
                $options[$i]->addLocalizableText(
                    $data['options'][$i]['value'],
                    $data['language'],
                );
            }
        }

        return redirect()->route('user.poll.show', ['id' => $poll->id]);
    }

    public function edit(int $id)
    {
        $poll = Poll::find($id);

        if ($poll === null) {
            abort(404);
        }

        $languages = Language::all();
        $poll->load(
            'question.translations.localizedTexts',
            'question.translations.defaultLocalizedText',
            'options.translations.localizedTexts',
            'options.translations.defaultLocalizedText',
        );

        return view('user.polls.edit', compact('poll', 'languages'));
    }

    public function update(Request $request, int $id)
    {
        $poll = Poll::find($id);

        if ($poll === null) {
            abort(404);
        }

        $poll->load(
            'question.translations.localizedTexts',
            'question.translations.defaultLocalizedText',
            'options.translations.localizedTexts',
            'options.translations.defaultLocalizedText',
        );

        $question = $poll->question;
        $options = $poll->options;
        $question_localizedTexts_ids = $question->translations->localizedTexts->pluck('id')->toArray();
        $options_localizedTexts_ids = $options->map(fn($option) => $option->translations->localizedTexts->pluck('id')->toArray());

        $request->validate([
            'data' => [
                'required', 'array',
                new UniqueInPath('*.language'),
                new UniqueInPath('*.question.id'),
                new UniqueInPath('*.options.*.id'),
                new InArray('*.question.id', $question_localizedTexts_ids),
                new InArray('*.options.0.id', $options_localizedTexts_ids[0]),
                new InArray('*.options.1.id', $options_localizedTexts_ids[1]),
            ],
            'data.*.language' => ['required', 'int', 'exists:languages,id'],
            'data.*.question.id' => ['nullable', 'int'],
            'data.*.question.value' => ['required', 'string', 'max:255'],
            'data.*.options' => ['required', 'array', 'min:2', 'max:2'],
            'data.*.options.*.id' => ['nullable', 'int'],
            'data.*.options.*.value' => ['required', 'string', 'max:255'],
        ]);

        $question->deleteLocalizableText(
            array_diff(
                $question_localizedTexts_ids,
                PathReducer::reduce('*.question.id', $request->input('data'))
            )
        );

        for($i = 0; $i < count($options); $i++) {
            $options[$i]->deleteLocalizableText(
                array_diff(
                    $options_localizedTexts_ids[$i],
                    PathReducer::reduce('*.options.'.$i.'.id', $request->input('data'))
                )
            );
        }

        foreach ($request->input('data') as $data) {
            if (is_null($data['question']['id'])) {
                $question->addLocalizableText(
                    $data['question']['value'],
                    $data['language'],
                );
            } else {
                $question->updateLocalizableText(
                    $data['question']['id'],
                    $data['question']['value'],
                    $data['language'],
                );
            }

            for ($i = 0; $i < count($data['options']); $i++) {
                if (is_null($data['options'][$i]['id'])) {
                    $options[$i]->addLocalizableText(
                        $data['options'][$i]['value'],
                        $data['language'],
                    );
                } else {
                    $options[$i]->updateLocalizableText(
                        $data['options'][$i]['id'],
                        $data['options'][$i]['value'],
                        $data['language'],
                    );
                }
            }
        }

        return redirect()->route('user.poll.show', ['id' => $poll->id]);
    }

    public function destroy(Request $request, int $id)
    {
        $poll = Poll::find($id);

        if ($poll === null) {
            abort(404);
        }

        $poll->delete();

        $redirectTo = $request->query->get('redirectTo');
        if ($redirectTo !== null) {
            return redirect($redirectTo);
        }

        return redirect()->route('user.poll.index');
    }
}
