<x-layout>
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
                            <a href="{{ route('polls.show', $poll->id) }}">
                                {{ $poll->question->translationOrDefault($language->id)->content }}
                            </a>
                        </h3>
                        <button onclick="location.href = '{{ route('polls.edit', $poll->id) }}'">
                            Edit
                        </button>
                        <x-delete-button route="{{ route('polls.destroy', $poll->id) }}"/>
                    </div>
                    <ul>
                        @foreach($poll->options as $option)
                            <li>{{ $option->translationOrDefault($language->id)->content }}</li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        @endforeach
        <button onclick="location.href = '{{ route('polls.create') }}'">New Poll</button>
        <button onclick="location.href = '{{ route('play.index') }}'">Play!</button>
    </div>
</x-layout>
