<div>
    <h1>
        {{ $poll->question->translationOrDefault($language->id)->content }}
    </h1>
    <div>
        <h3>First Option:</h3>
        <p>
            @if($poll->options->count() >= 1)
                {{ $poll->options[0]->translationOrDefault($language->id)->content }}
            @endif
        </p>
    </div>
    <div>
        <h3>Second Option:</h3>
        <p>
            @if($poll->options->count() >= 2)
                {{ $poll->options[1]->translationOrDefault($language->id)->content }}
            @endif
        </p>
    </div>
    <div>
        <button onclick="location.href = '{{ route('user.poll.create') }}'">New Poll</button>
        <button>Edit</button>
        <x-delete-button
            :route="route('user.poll.destroy', $poll->id).'?'.http_build_query([
                'redirectTo' =>
                    $nextPollId !== null || $prevPollId !== null
                        ? route('user.poll.show', $nextPollId ?? $prevPollId)
                        : route('user.poll.index')])" />
    </div>
    <div>
        <button
            onclick="location.href = '/user/polls/{{$prevPollId}}'"
            @disabled(is_null($prevPollId))
        >
            Prev
        </button>
        <button onclick="location.href = '/user/polls'">Index</button>
        <button
            onclick="location.href = '/user/polls/{{$nextPollId}}'"
            @disabled(is_null($nextPollId))
        >
            Next
        </button>
    </div>
</div>
