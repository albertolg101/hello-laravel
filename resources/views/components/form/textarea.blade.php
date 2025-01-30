@include('components.form._label')
<textarea
    name="{{$name}}"
    class="form-element {{ $class ?? '' }}"
    {{ $attributes->except(['name', 'class', 'defaultValue'])}}
>
    {{ $defaultValue ?? '' }}
</textarea>
