<div>
    <div id="form-body">
        @for($i = 0; $i < count($poll); $i++)
            <div>
                <x-form.hidden-input
                    wire:model="poll.{{$i}}.question.id"
                    name="data[{{$i}}][question][id]"
                />
                <x-form.textarea
                    wire:model="poll.{{$i}}.question.value"
                    name="data[{{$i}}][question][value]"
                    label="Question:"
                />

                <x-form.hidden-input
                    wire:model="poll.{{$i}}.options.0.id"
                    name="data[{{$i}}][options][0][id]"
                    class="firstOption"
                />
                <x-form.textarea
                    wire:model="poll.{{$i}}.options.0.value"
                    name="data[{{$i}}][options][0][value]"
                    class="firstOption"
                    label="First Option:"
                />

                <x-form.hidden-input
                    wire:model="poll.{{$i}}.options.1.id"
                    name="data[{{$i}}][options][1][id]"
                    class="secondOption"/>
                <x-form.textarea
                    wire:model="poll.{{$i}}.options.1.value"
                    name="data[{{$i}}][options][1][value]"
                    class="secondOption"
                    label="Second Option:"
                />

                <x-form.select
                    wire:model="poll.{{$i}}.language"
                    name="data[{{$i}}][language]"
                    label="Language:"
                    :options="$languages->pluck('english_name', 'id')->toArray()"
                />
                <x-form.checkbox
                    wire:model="poll.{{$i}}.is_default"
                    name="data[{{$i}}][is_default]"
                    label="Is default:"/>

                <button
                    type="button"
                    class="delete-button"
                    wire:click="removeTranslation({{$i}})"
                >
                    Delete
                </button>
            </div>
        @endfor
    </div>
    <div id="actions">
        <button type="button" onclick="location.href = '{{ route('polls.index') }}'">Cancel</button>
        <button type="button" wire:click="addTranslation()">Add Translation</button>
        <button type="submit">
            {{ $variant === "create" ? "Create" : "Edit" }} Poll
        </button>
    </div>
</div>
