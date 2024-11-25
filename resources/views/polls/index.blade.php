<div>
    @foreach($polls as $poll)
        <div>
            <div>
                <h3
                    style="
                        display: inline;
                        white-space: nowrap;
                    "
                >
                    {{ $poll->question->text() }}
                </h3>
                <button>
                    Edit
                </button>
                <button>
                    Delete
                </button>
            </div>
            <ul>
                @foreach($poll->options as $option)
                    <li>{{ $option->text() }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
