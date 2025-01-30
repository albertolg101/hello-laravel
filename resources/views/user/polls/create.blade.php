<x-layout>
    <x-polls-layout title="Create">
        <form
            id="main-form"
            action="{{ route('polls.store') }}"
            method="post"
        >
            @csrf
            <livewire:user.polls.form
                variant="create"
                :languages=$languages
                :poll="$pollData['translations'] ?? []"
            />
        </form>
    </x-polls-layout>
</x-layout>
