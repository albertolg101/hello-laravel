<header>
    <h1>Pick&Slide</h1>
    <h2>{{ $title }}</h2>
    <button onclick="location.href = '{{ route('play.index') }}'">Play!</button>
</header>
<div class="divider">
    <hr class="solid"/>
</div>
<div id="polls-layout">
    <div id="polls-body">
        {{ $slot }}
    </div>
</div>
