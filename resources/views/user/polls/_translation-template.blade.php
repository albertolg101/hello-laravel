<div>
    <x-form.textarea name="data[0][question]" label="Question:"/>
    <x-form.textarea name="data[0][options][]" id="firstOption" label="First Option:"/>
    <x-form.textarea name="data[0][options][]" id="secondOption" label="Second Option:"/>

    <x-form.select
        name="data[0][language]"
        label="Language:"
        :options="$languages->pluck('english_name', 'id')->toArray()"
    />

    <button type="button" class="delete-button">Delete</button>
</div>
