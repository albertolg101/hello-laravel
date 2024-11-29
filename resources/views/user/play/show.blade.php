<h1>
    {{ $poll->question->translationOrDefault($language)->content }}
</h1>
<div>
    <div>
        {{ $poll->options[0]->translationOrDefault($language)->content }}
        @include('user.play._vote-button', ['option' => $poll->options[0]])
        {{ $poll->options[0]->votes_count }}
    </div>
    <div>
        {{ $poll->options[1]->translationOrDefault($language)->content }}
        @include('user.play._vote-button', ['option' => $poll->options[1]])
        {{ $poll->options[1]->votes_count }}
    </div>
</div>
