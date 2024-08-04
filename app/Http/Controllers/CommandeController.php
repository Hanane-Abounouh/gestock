<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Affiche la liste de toutes les commandes avec les relations client et produit.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $commandes = Commande::with(['client', 'produit'])->get();
        return response()->json([
            'message' => 'Liste de toutes les commandes récupérée avec succès.',
            'data' => $commandes
        ], 200);
    }

    /**
     * Crée une nouvelle commande.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
            'prix_total' => 'required|numeric',
        ]);

        $commande = Commande::create($validated);

        return response()->json([
            'message' => 'Commande créée avec succès.',
            'data' => $commande
        ], 201);
    }

    /**
     * Affiche les détails d'une commande spécifique avec les relations client et produit.
     *
     * @param \App\Models\Commande $commande
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Commande $commande)
    {
        $commande->load(['client', 'produit']);
        return response()->json([
            'message' => 'Détails de la commande récupérés avec succès.',
            'data' => $commande
        ], 200);
    }

    /**
     * Met à jour les informations d'une commande spécifique.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commande $commande
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'client_id' => 'sometimes|exists:clients,id',
            'produit_id' => 'sometimes|exists:produits,id',
            'quantite' => 'sometimes|integer',
            'prix_total' => 'sometimes|numeric',
        ]);

        $commande->update($validated);

        return response()->json([
            'message' => 'Commande mise à jour avec succès.',
            'data' => $commande
        ], 200);
    }

    /**
     * Supprime une commande spécifique.
     *
     * @param \App\Models\Commande $commande
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Commande $commande)
    {
        $commande->delete();

        return response()->json([
            'message' => 'Commande supprimée avec succès.'
        ], 200); // Changer à 204 si vous ne voulez pas inclure un corps dans la réponse
    }
}
