<form
    action="{{ route('user.poll.store') }}"
    method="post"
>
    @csrf
    <label for="question">Question:</label>
    <textarea name="question"></textarea>

    <label for="firstOption">First Option:</label>
    <textarea name="options[]" id="firstOption"></textarea>

    <label for="secondOption">Second Option:</label>
    <textarea name="options[]" id="secondOption"></textarea>

    <label for="language">Language:</label>
    <select name="language">
        @foreach($languages as $language)
            <option value="{{ $language->id }}">{{ $language->english_name }}</option>
        @endforeach
    </select>

    <button type="submit">Create Poll</button>
</form>
