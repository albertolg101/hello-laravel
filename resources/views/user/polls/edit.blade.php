<x-layout>
    <x-polls-layout title="Edit">
        <form
            id="main-form"
            action="{{ route('polls.update', $pollData["id"]) }}"
            method="post"
        >
            @csrf
            @method('PUT')
            <livewire:user.polls.form
                variant="edit"
                :languages=$languages
                :poll="$pollData['translations']"
            />
        </form>
    </x-polls-layout>
</x-layout>
