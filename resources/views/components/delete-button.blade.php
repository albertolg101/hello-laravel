<form
    style="display: inline;"
    method="POST"
    action="{{ $route }}"
    >
    @csrf
    @method('DELETE')
    <button>Delete</button>
</form>
