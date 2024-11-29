<x-layout>
    <x-polls-layout title="Index">
        <div>
            @foreach($polls as $poll)
                <ul>
                    <li style="padding: 10px 0; display: flex; flex-direction: column; gap: 5px">
                        <div style="overflow: hidden; text-overflow: ellipsis">
                            <h3
                                style="display: inline; white-space: nowrap;"
                            >
                                <a href="{{ route('polls.show', $poll->id) }}">
                                    {{ $poll->question->translationOrDefault($language->id)->content }}
                                </a>
                            </h3>
                        </div>
                        <ul>
                            @foreach($poll->options as $option)
                                <li>{{ $option->translationOrDefault($language->id)->content }}</li>
                            @endforeach
                        </ul>
                        <div>
                            <button onclick="location.href = '{{ route('polls.edit', $poll->id) }}'">
                                Edit
                            </button>
                            <x-delete-button route="{{ route('polls.destroy', $poll->id) }}"/>
                        </div>
                    </li>
                </ul>
            @endforeach
            <button onclick="location.href = '{{ route('polls.create') }}'">New Poll</button>
        </div>
    </x-polls-layout>
</x-layout>
