<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Poll;
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
