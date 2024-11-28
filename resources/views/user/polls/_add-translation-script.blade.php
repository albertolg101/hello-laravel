<script>
    const mainFormBody = document.querySelector('#main-form > #form-body')

    function addTranslation(index, poll=null) {
        const translation = document.createElement('div')
        translation.id = `translation-${index}`
        translation.innerHTML = `@include('user.polls._translation-template')`

        translation.querySelectorAll('label').forEach(label => {
            label.setAttribute('for', label.getAttribute('for').replace('data[0]', `data[${index}]`))
        })
        translation.querySelectorAll('.form-element').forEach(element => {
            element.setAttribute('name', element.name.replace('data[0]', `data[${index}]`))
        })
        translation.querySelector('.delete-button').addEventListener('click', () => {
            mainFormBody.querySelector(`#translation-${index}`).remove()
        })

        if (poll !== null) {
            translation.querySelector('.form-element[name="data[' + index + '][question][id]"]').value = poll.question.id
            translation.querySelector('.form-element[name="data[' + index + '][question][value]"]').innerHTML = poll.question.value
            translation.querySelector('.form-element[name="data[' + index + '][options][0][id]"].firstOption').value = poll.options[0].id
            translation.querySelector('.form-element[name="data[' + index + '][options][0][value]"].firstOption').innerHTML = poll.options[0].value
            translation.querySelector('.form-element[name="data[' + index + '][options][1][id]"].secondOption').value = poll.options[1].id
            translation.querySelector('.form-element[name="data[' + index + '][options][1][value]"].secondOption').innerHTML = poll.options[1].value
            translation.querySelector('.form-element[name="data[' + index + '][language]"]').value = poll.language_id
        }

        mainFormBody.appendChild(translation)
    }

    let index = 0
    document.querySelector('#add-translation').addEventListener('click', () => {
        addTranslation(index);
        index++
    })

    @if(isset($poll))
        const poll = @json($poll);

        index = poll.question.translations.localized_texts.length;
        for (let i = 0; i < index; i++) {
            const pollTranslation = {
                question: {
                    id: poll.question.translations.localized_texts[i].id,
                    value: poll.question.translations.localized_texts[i].content
                },
                options: [
                    {
                        id: poll.options[0].translations.localized_texts[i].id,
                        value: poll.options[0].translations.localized_texts[i].content
                    },
                    {
                        id: poll.options[1].translations.localized_texts[i].id,
                        value: poll.options[1].translations.localized_texts[i].content
                    }
                ],
                language_id: poll.question.translations.localized_texts[i].language_id
            }

            addTranslation(i, pollTranslation);
        }
    @else
        addTranslation(index);
        index++
    @endif
</script>
