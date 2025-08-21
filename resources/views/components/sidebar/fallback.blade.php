@props(['role' => 'client'])

<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800">
                Configuration de la sidebar non trouvée
            </h3>
            <div class="mt-2 text-sm text-yellow-700">
                <p>La configuration pour le rôle "{{ $role }}" n'a pas pu être chargée.</p>
                <p class="mt-1">Veuillez contacter l'administrateur.</p>
            </div>
        </div>
    </div>
</div>


