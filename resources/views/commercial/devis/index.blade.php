@extends('layouts.commercial')

@section('page-title', 'Gestion des devis')
@section('page-description', 'Créer et gérer les devis pour vos clients')

@section('content')
    <!-- Composant Livewire pour la liste des devis -->
    @livewire('commercial.devis-list')
    
    <!-- Composant Livewire pour le modal de création -->
    @livewire('commercial.create-devis-modal')
@endsection

@push('scripts')
<script>
    // Écouter l'événement de création de devis
    document.addEventListener('livewire:init', () => {
        Livewire.on('devisCreated', (devisId) => {
            // Rediriger vers la page du devis créé
            window.location.href = `/commercial/devis/${devisId}`;
        });
    });
</script>
@endpush
