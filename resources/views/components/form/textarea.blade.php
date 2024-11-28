@include('components.form._label')
<textarea
    name="{{$name}}"
    class="form-element {{ $class ?? '' }}"
>{{ $defaultValue ?? "" }}</textarea>
