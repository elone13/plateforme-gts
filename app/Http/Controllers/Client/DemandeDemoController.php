<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DemandeDemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeDemoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $demandesDemo = DemandeDemo::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('client.demandes-demo.index', compact('demandesDemo'));
    }

    public function show(DemandeDemo $demandeDemo)
    {
        $user = Auth::user();
        
        // Vérifier que la demande appartient bien à l'utilisateur connecté
        if ($demandeDemo->email !== $user->email) {
            abort(403, 'Accès non autorisé');
        }
        
        return view('client.demandes-demo.show', compact('demandeDemo'));
    }
}


