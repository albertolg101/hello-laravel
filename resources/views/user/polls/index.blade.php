<div>
    @foreach($polls as $poll)
        <ul>
            <li>
                <div>
                    <h3
                        style="
                            display: inline;
                            white-space: nowrap;
                        "
                    >
                        <a href="/user/polls/{{$poll->id}}">
                            {{ $poll->question->translationOrDefault($language->id)->content }}
                        </a>
                    </h3>
                    <button onclick="location.href = '{{ route('user.poll.edit', $poll->id) }}'">
                        Edit
                    </button>
                    <x-delete-button route="{{ route('user.poll.destroy', $poll->id) }}" />
                </div>
                <ul>
                    @foreach($poll->options as $option)
                        <li>{{ $option->translationOrDefault($language->id)->content }}</li>
                    @endforeach
                </ul>
            </li>
        </ul>
    @endforeach
    <button onclick="location.href = '{{ route('user.poll.create') }}'">New Poll</button>
</div>
