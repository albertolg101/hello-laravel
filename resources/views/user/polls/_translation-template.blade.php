<div>
    <x-form.hidden-input name="data[0][question][id]"/>
    <x-form.textarea name="data[0][question][value]" label="Question:"/>

    <x-form.hidden-input name="data[0][options][0][id]" class="firstOption"/>
    <x-form.textarea name="data[0][options][0][value]" class="firstOption" label="First Option:"/>

    <x-form.hidden-input name="data[0][options][1][id]" class="secondOption"/>
    <x-form.textarea name="data[0][options][1][value]" class="secondOption" label="Second Option:"/>

    <x-form.select
        name="data[0][language]"
        label="Language:"
        :options="$languages->pluck('english_name', 'id')->toArray()"
    />

    <button type="button" class="delete-button">Delete</button>
</div>
