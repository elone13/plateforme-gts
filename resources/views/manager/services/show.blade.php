@extends('layouts.manager')

@section('page-title', 'Détails du Service')
@section('page-description', $service->nom)

@section('content')

<!-- Composant Livewire complet pour la gestion des éléments -->
@livewire('item-manager', ['service' => $service])

@endsection
