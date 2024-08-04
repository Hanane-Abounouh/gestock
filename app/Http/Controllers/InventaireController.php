<?php

namespace App\Http\Controllers;

use App\Models\Inventaire;
use Illuminate\Http\Request;

class InventaireController extends Controller
{
    public function index()
    {
        return Inventaire::with('produit')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
        ]);

        $inventaire = Inventaire::create($validated);

        return response()->json($inventaire, 201);
    }

    public function show(Inventaire $inventaire)
    {
        $inventaire->load('produit');
        return $inventaire;
    }

    public function update(Request $request, Inventaire $inventaire)
    {
        $validated = $request->validate([
            'produit_id' => 'sometimes|exists:produits,id',
            'quantite' => 'sometimes|integer',
        ]);

        $inventaire->update($validated);

        return response()->json($inventaire, 200);
    }

    public function destroy(Inventaire $inventaire)
    {
        $inventaire->delete();

        return response()->json(null, 204);
    }
}
