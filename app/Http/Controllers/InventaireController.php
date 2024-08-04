<?php
namespace App\Http\Controllers;

use App\Models\Inventaire;
use Illuminate\Http\Request;

class InventaireController extends Controller
{
    /**
     * Affiche la liste de tous les inventaires avec les relations produit.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $inventaires = Inventaire::with('produit')->get();
        return response()->json([
            'message' => 'Liste de tous les inventaires récupérée avec succès.',
            'data' => $inventaires
        ], 200);
    }

    /**
     * Crée un nouvel inventaire.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
        ]);

        $inventaire = Inventaire::create($validated);

        return response()->json([
            'message' => 'Inventaire créé avec succès.',
            'data' => $inventaire
        ], 201);
    }

    /**
     * Affiche les détails d'un inventaire spécifique avec la relation produit.
     *
     * @param \App\Models\Inventaire $inventaire
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Inventaire $inventaire)
    {
        $inventaire->load('produit');
        return response()->json([
            'message' => 'Détails de l\'inventaire récupérés avec succès.',
            'data' => $inventaire
        ], 200);
    }

    /**
     * Met à jour les informations d'un inventaire spécifique.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Inventaire $inventaire
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Inventaire $inventaire)
    {
        $validated = $request->validate([
            'produit_id' => 'sometimes|exists:produits,id',
            'quantite' => 'sometimes|integer',
        ]);

        $inventaire->update($validated);

        return response()->json([
            'message' => 'Inventaire mis à jour avec succès.',
            'data' => $inventaire
        ], 200);
    }

    /**
     * Supprime un inventaire spécifique.
     *
     * @param \App\Models\Inventaire $inventaire
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Inventaire $inventaire)
    {
        $inventaire->delete();

        return response()->json([
            'message' => 'Inventaire supprimé avec succès.'
        ], 204); // Changer à 204 si vous ne voulez pas inclure un corps dans la réponse
    }
}
