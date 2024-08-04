<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Affiche la liste de tous les fournisseurs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return response()->json([
            'message' => 'Liste de tous les fournisseurs récupérée avec succès.',
            'data' => $fournisseurs
        ], 200);
    }

    /**
     * Crée un nouveau fournisseur.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation des données envoyées dans la requête
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'informations_contact' => 'nullable|string',
        ]);

        // Création du fournisseur
        $fournisseur = Fournisseur::create($validated);

        return response()->json([
            'message' => 'Fournisseur créé avec succès.',
            'data' => $fournisseur
        ], 201);
    }

    /**
     * Affiche les détails d'un fournisseur spécifique.
     *
     * @param \App\Models\Fournisseur $fournisseur
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Fournisseur $fournisseur)
    {
        return response()->json([
            'message' => 'Détails du fournisseur récupérés avec succès.',
            'data' => $fournisseur
        ], 200);
    }

    /**
     * Met à jour les informations d'un fournisseur spécifique.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fournisseur $fournisseur
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        // Validation des données envoyées dans la requête
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'informations_contact' => 'nullable|string',
        ]);

        // Mise à jour des informations du fournisseur
        $fournisseur->update($validated);

        return response()->json([
            'message' => 'Fournisseur mis à jour avec succès.',
            'data' => $fournisseur
        ], 200);
    }

    /**
     * Supprime un fournisseur spécifique.
     *
     * @param \App\Models\Fournisseur $fournisseur
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Fournisseur $fournisseur)
    {
        // Suppression du fournisseur
        $fournisseur->delete();

        return response()->json([
            'message' => 'Fournisseur supprimé avec succès.'
        ], 200); // Changer à 204 si vous ne voulez pas inclure un corps dans la réponse
    }
}
