<div>
    <h3>Composant de test</h3>
    <p>{{ $message }}</p>
    
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    
    <button wire:click="testAction" class="btn-primary">
        Tester l'action
    </button>
</div>
