<form
    id="main-form"
    action="{{ route('user.poll.store') }}"
    method="post"
>
    @csrf
    <div id="form-body"></div>
    <button type="button" onclick="location.href = '{{ URL::previous() }}'">Cancel</button>
    <button type="button" id='add-translation' >Add Translation</button>
    <button type="submit">Create Poll</button>
</form>
<script>
    const mainFormBody = document.querySelector('#main-form > #form-body')

    function addTranslation(index) {
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
        mainFormBody.appendChild(translation)
    }

    let index = 0
    document.querySelector('#add-translation').addEventListener('click', () => {
        addTranslation(index);
        index++
    })
    document.querySelector('#add-translation').click()
</script>
