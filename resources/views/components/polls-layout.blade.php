<header>
    <h1>Pick&Slide</h1>
    <h2>{{ $title }}</h2>
    <div>
        <button onclick="location.href = '{{ route('play.index') }}'">Play!</button>
        <x-post-button route="{{ route('logout') }}">Log out</x-post-button>
    </div>
    <div style="padding-top: 20px">
        <livewire:fun-fact />
    </div>
    <div style="padding-top: 20px">
        <livewire:get-api-token />
    </div>
</header>
<div class="divider">
    <hr class="solid"/>
</div>
<div id="polls-layout">
    <div id="polls-body">
        {{ $slot }}
    </div>
</div>
