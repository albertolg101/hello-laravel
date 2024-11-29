<x-layout>
    <div id="game">
        <div class="question-container">
            <h1>
                {{ $poll->question->translationOrDefault($defaultLanguage)->content }}
            </h1>
        </div>
        <div class="options-container">
            <div id="first-option" class="option">
                {{ $poll->options[0]->translationOrDefault($defaultLanguage)->content }}
            </div>
            <div id="second-option" class="option">
                {{ $poll->options[1]->translationOrDefault($defaultLanguage)->content }}
            </div>
        </div>
        <a href="{{ route('polls.index') }}">
            <span id="close-button" class="material-symbols-outlined">
                close
            </span>
        </a>
        <div id="actions">
            <x-form.select
                id="language-selector"
                name="language"
                :options="$languages->pluck('english_name', 'id')->toArray()"
            />
            @if($isLoggedIn === true)
                <x-post-button route="{{ route('logout') }}">Log out</x-post-button>
            @else
                <button onclick="location.href = '{{ route('login') }}'">
                    Log in
                </button>
            @endif
        </div>
    </div>
    <script>
        const firstOption = document.getElementById('first-option');
        const secondOption = document.getElementById('second-option');
        const languageSelector = document.getElementById('language-selector');
        const poll = @json($poll);
        const options = poll.options;

        function handleClick(optionIndex) {
            const languageId = document.getElementById('language-selector').value;
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
                const form = div.querySelector('form')
                form.action = form.action + '?defaultLanguage=' + languageId;
                document.body.appendChild(div);
                div.querySelector('button').click();
            });
        }

        function changeLanguage() {
            const languageId = document.getElementById('language-selector').value;
            const question = document.querySelector('.question-container h1');
            const firstOption = document.getElementById('first-option');
            const secondOption = document.getElementById('second-option');

            function getTranslationOrDefault(translatable, languageId) {
                translation = translatable.translations.find(translation => translation.language_id == languageId);
                if (translation === undefined) {
                    translation = translatable.translations.find(translation => translation.is_default === true);
                }
                if (translation === undefined) {
                    translation = translatable.translations[0];
                }

                return translation.content
            }

            question.innerHTML = getTranslationOrDefault(poll.question, languageId);
            firstOption.innerHTML = getTranslationOrDefault(poll.options[0], languageId);
            secondOption.innerHTML = getTranslationOrDefault(poll.options[1], languageId);
        }

        languageSelector.value = {{ $defaultLanguage }};
        firstOption.addEventListener('click', () => handleClick(0), {once: true});
        secondOption.addEventListener('click', () => handleClick(1), {once: true});
        languageSelector.addEventListener('change', changeLanguage);
    </script>
</x-layout>
