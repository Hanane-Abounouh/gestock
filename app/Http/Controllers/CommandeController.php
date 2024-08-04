<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        return Commande::with(['client', 'produit'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
            'prix_total' => 'required|numeric',
        ]);

        $commande = Commande::create($validated);

        return response()->json($commande, 201);
    }

    public function show(Commande $commande)
    {
        $commande->load(['client', 'produit']);
        return $commande;
    }

    public function update(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'client_id' => 'sometimes|exists:clients,id',
            'produit_id' => 'sometimes|exists:produits,id',
            'quantite' => 'sometimes|integer',
            'prix_total' => 'sometimes|numeric',
        ]);

        $commande->update($validated);

        return response()->json($commande, 200);
    }

    public function destroy(Commande $commande)
    {
        $commande->delete();

        return response()->json(null, 204);
    }
}
