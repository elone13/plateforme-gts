<?php

namespace App\Http\Controllers;

use App\Models\DemandeDemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemandeDemoController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:45',
            'email' => 'required|email|max:45',
            'telephone' => 'required|string|max:45',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DemandeDemo::create([
            'date' => now()->format('Y-m-d'),
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'message' => $request->message,
            'statut' => 'en_attente',
        ]);

        return back()->with('success', 'Votre demande de démo a été envoyée avec succès ! Nous vous contacterons bientôt.');
    }
} 