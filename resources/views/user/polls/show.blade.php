<x-layout>
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
            <button onclick="location.href = '{{ route('polls.create') }}'">New Poll</button>
            <button onclick="location.href = '{{ route('polls.edit', $poll) }}'">Edit</button>
            <x-delete-button
                :route="route('polls.destroy', $poll->id).'?'.http_build_query([
                'redirectTo' =>
                    $nextPollId !== null || $prevPollId !== null
                        ? route('polls.show', $nextPollId ?? $prevPollId)
                        : route('polls.index')])"/>
        </div>
        <div>
            <button
                @if(!is_null($prevPollId))
                    onclick="location.href = '{{ route('polls.show', $prevPollId) }}'"
                @endif
                @disabled(is_null($prevPollId))
            >
                Prev
            </button>
            <button onclick="location.href = '{{ route('polls.index') }}'">Index</button>
            <button
                @if(!is_null($nextPollId))
                    onclick="location.href = '{{ route('polls.show', $nextPollId) }}'"
                @endif
                @disabled(is_null($nextPollId))
            >
                Next
            </button>
        </div>
    </div>
</x-layout>
