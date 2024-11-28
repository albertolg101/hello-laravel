@include('components.form._label')
<select name="{{$name}}" class="form-element">
    @foreach($options as $key => $option)
        <option value="{{ $key }}">{{ $option }}</option>
    @endforeach
</select>
