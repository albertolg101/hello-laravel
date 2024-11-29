<form
    style="display: inline;"
    method="POST"
    action="{{ $route }}"
>
    @csrf
    <button>
        @if(isset($slot))
            {{ $slot }}
        @else
            Post
        @endif
    </button>
</form>
