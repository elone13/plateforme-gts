<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Détails du Devis #{{ $devis->reference }}
            </h2>
            <div class="flex space-x-2">
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    {{ $devis->statut === 'accepte' ? 'bg-green-100 text-green-800' : 
                       ($devis->statut === 'refuse' ? 'bg-red-100 text-red-800' : 
                       'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($devis->statut) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 space-y-8">
                    <!-- En-tête du devis -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-6 border-b border-gray-200">
                        <div class="mb-4 md:mb-0">
                            <h1 class="text-2xl font-bold text-gray-900">Devis #{{ $devis->reference }}</h1>
                            <p class="text-sm text-gray-500 mt-1">
                                Créé le {{ \Carbon\Carbon::parse($devis->date)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg w-full md:w-auto">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">VALIDITÉ JUSQU'AU</h3>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($devis->date_validite)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Informations client -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                Client
                            </h3>
                            @if($devis->client)
                                <div class="space-y-2">
                                    <p class="text-gray-900 font-medium">{{ $devis->client->nom }}</p>
                                    <p class="text-sm text-gray-600">{{ $devis->client->email }}</p>
                                    <p class="text-sm text-gray-600">{{ $devis->client->telephone }}</p>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Aucun client associé</p>
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                Détails du devis
                            </h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Référence :</dt>
                                    <dd class="text-sm font-medium">{{ $devis->reference }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Date d'émission :</dt>
                                    <dd class="text-sm">{{ \Carbon\Carbon::parse($devis->date)->format('d/m/Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Date de validité :</dt>
                                    <dd class="text-sm">{{ \Carbon\Carbon::parse($devis->date_validite)->format('d/m/Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Tableau des prestations -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Prestations</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total HT</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($devis->items as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->service->nom ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $item->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                                {{ number_format($item->prix_unitaire, 2, ',', ' ') }} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                                {{ number_format($item->prix_unitaire, 2, ',', ' ') }} €
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Aucune prestation pour le moment
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Totaux -->
                    <div class="bg-gray-50 p-6 rounded-lg mt-8">
                        <div class="max-w-md ml-auto space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Sous-total HT :</span>
                                <span class="text-sm font-medium">{{ number_format($devis->montant_total, 2, ',', ' ') }} €</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">TVA (20%) :</span>
                                <span class="text-sm font-medium">{{ number_format($devis->montant_total * 0.2, 2, ',', ' ') }} €</span>
                            </div>
                            <div class="flex justify-between pt-2 mt-2 border-t border-gray-200">
                                <span class="text-base font-bold">Total TTC :</span>
                                <span class="text-base font-bold">{{ number_format($devis->montant_total * 1.2, 2, ',', ' ') }} €</span>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions -->
                    @if($devis->conditions)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Conditions particulières</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700 whitespace-pre-line">{{ $devis->conditions }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row justify-between items-center pt-8 mt-8 border-t border-gray-200 space-y-4 sm:space-y-0">
                        <a href="{{ route('commercial.devis.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                            </svg>
                            Retour à la liste
                        </a>
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                            <a href="{{ route('commercial.devis.edit', $devis) }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>
                                Modifier le devis
                            </a>
                            <a href="{{ route('commercial.devis.download', $devis) }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                    <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0017 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                </svg>
                                Télécharger le PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
