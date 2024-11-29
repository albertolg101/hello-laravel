<form
    style="display: inline;"
    action="{{ route('vote.store') }}"
    method="post"
>
    @csrf
    <input type="hidden" name="option" value="{{ $option->id }}"/>
    <button
        type="submit"
    >+
    </button>
</form>
