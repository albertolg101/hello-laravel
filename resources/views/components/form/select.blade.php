@include('components.form._label')
<select
    @if(isset($id)) id="{{$id}}" @endif
    name="{{$name}}"
    class="form-element"
>
    @foreach($options as $key => $option)
        <option value="{{ $key }}">{{ $option }}</option>
    @endforeach
</select>
