<x-layout>
    <x-polls-layout title="Create">
        <form
            id="main-form"
            action="{{ route('polls.store') }}"
            method="post"
        >
            @csrf
            <div id="form-body"></div>
            <button type="button" onclick="location.href = '{{ URL::previous() }}'">Cancel</button>
            <button type="button" id='add-translation'>Add Translation</button>
            <button type="submit">Create Poll</button>
        </form>
        @include('user.polls._add-translation-script')
    </x-polls-layout>
</x-layout>
