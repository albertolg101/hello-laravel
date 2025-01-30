<div>
    <div>
        @if(!is_null(session('api-token')))
            <div>
                <h3>Your Api Token</h3>
                <p>{{ session('api-token') }}</p>
            </div>
        @endif
        <button wire:click="getApiToken()">Get an Api Token</button>
    </div>
</div>
