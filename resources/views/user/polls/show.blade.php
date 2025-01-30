<x-layout>
    <x-polls-layout title="Show">
        <div>
            <h1>
                {{ $poll->question }}
            </h1>
            <div>
                <h3>First Option:</h3>
                <p>
                    @if(count($poll->options) >= 1)
                        {{ $poll->options[0]->content }}
                    @endif
                </p>
            </div>
            <div>
                <h3>Second Option:</h3>
                <p>
                    @if(count($poll->options) >= 2)
                        {{ $poll->options[1]->content }}
                    @endif
                </p>
            </div>
            <div>
                <button onclick="location.href = '{{ route('polls.create') }}'">New Poll</button>
                <button onclick="location.href = '{{ route('polls.edit', $poll->id) }}'">Edit</button>
                <x-delete-button
                    :route="route('polls.destroy', $poll->id).'?'.http_build_query([
                'redirectTo' =>
                    $poll->nextPollId !== null || $poll->prevPollId !== null
                        ? route('polls.show', $poll->nextPollId ?? $poll->prevPollId)
                        : route('polls.index')])"/>
            </div>
            <div>
                <button
                    @if(!is_null($poll->prevPollId))
                        onclick="location.href = '{{ route('polls.show', $poll->prevPollId) }}'"
                    @endif
                    @disabled(is_null($poll->prevPollId))
                >
                    Prev
                </button>
                <button onclick="location.href = '{{ route('polls.index') }}'">Index</button>
                <button
                    @if(!is_null($poll->nextPollId))
                        onclick="location.href = '{{ route('polls.show', $poll->nextPollId) }}'"
                    @endif
                    @disabled(is_null($poll->nextPollId))
                >
                    Next
                </button>
            </div>
        </div>
    </x-polls-layout>
</x-layout>
