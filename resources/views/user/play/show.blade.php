<x-layout>
    <div id="game">
        <div class="question-container">
            <h1>
                {{ $poll->question->translationOrDefault($language)->content }}
            </h1>
        </div>
        <div class="options-container">
            <div id="first-option" class="option">
                {{ $poll->options[0]->translationOrDefault($language)->content }}
            </div>
            <div id="second-option" class="option">
                {{ $poll->options[1]->translationOrDefault($language)->content }}
            </div>
        </div>
        <a href="{{ route('polls.index') }}">
            <span id="close-button" class="material-symbols-outlined">
                close
            </span>
        </a>

    </div>
    <script>
        const firstOption = document.getElementById('first-option');
        const secondOption = document.getElementById('second-option');
        const options = @json($poll->options);

        function handleClick(optionIndex) {
            const votes = [options[0].votes_count, options[1].votes_count];

            if (optionIndex === 0){
                votes[0]++;
            } else {
                votes[1]++;
            }

            const votesPercentage = [
                votes[0] / (votes[0] + votes[1]) * 100,
                votes[1] / (votes[0] + votes[1]) * 100
            ];

            firstOption.innerHTML = `${Math.floor(votesPercentage[0])}%`;
            secondOption.innerHTML = `${Math.ceil(votesPercentage[1])}%`;
            firstOption.style.width = `${votesPercentage[0]}%`;
            secondOption.style.width = `${votesPercentage[1]}%`;
            document.getElementById('game').addEventListener('pointerup', () => {
                const div = document.createElement('div')
                div.style.display = 'none';
                div.innerHTML = optionIndex === 0 ?
                    `@include('user.play._vote-button', ['option' => $poll->options[0]])` :
                    `@include('user.play._vote-button', ['option' => $poll->options[1]])`;
                document.body.appendChild(div);
                div.querySelector('button').click();
            });
        }

        firstOption.addEventListener('click', () => handleClick(0), {once: true});
        secondOption.addEventListener('click', () => handleClick(1), {once: true});
    </script>
</x-layout>
