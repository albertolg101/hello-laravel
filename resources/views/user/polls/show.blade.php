<div>
    <h1>
        {{ $poll->question->translationOrDefault($language->id)->content }}
    </h1>
    <div>
        <h3>First Question:</h3>
        <p>
            @if($poll->options->count() >= 1)
                {{ $poll->options[0]->translationOrDefault($language->id)->content }}
            @endif
        </p>
    </div>
    <div>
        <h3>Second Question:</h3>
        <p>
            @if($poll->options->count() >= 2)
                {{ $poll->options[1]->translationOrDefault($language->id)->content }}
            @endif
        </p>
    </div>
    <div>
        <button>New</button>
        <button>Edit</button>
        <button>Delete</button>
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
