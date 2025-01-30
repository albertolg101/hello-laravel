<input
    type="hidden"
    name="{{ $name }}"
    class="form-element {{ $class ?? '' }}"
    {{ $attributes->except(['name', 'class']) }}
/>
