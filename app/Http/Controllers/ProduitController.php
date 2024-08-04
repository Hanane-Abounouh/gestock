<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    /**
     * Affiche la liste de tous les produits.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $produits = Produit::all();
        return response()->json([
            'message' => 'Liste de tous les produits récupérée avec succès.',
            'data' => $produits
        ], 200);
    }

    /**
     * Crée un nouveau produit.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $produit = Produit::create($request->all());

        return response()->json([
            'message' => 'Produit créé avec succès.',
            'data' => $produit
        ], 201);
    }

    /**
     * Affiche les détails d'un produit spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        return response()->json([
            'message' => 'Détails du produit récupérés avec succès.',
            'data' => $produit
        ], 200);
    }

    /**
     * Met à jour les informations d'un produit spécifique.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|string|max:255',
            'categorie_id' => 'sometimes|exists:categories,id',
            'fournisseur_id' => 'sometimes|exists:fournisseurs,id',
            'quantite' => 'sometimes|integer',
            'prix' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $produit->update($request->all());

        return response()->json([
            'message' => 'Produit mis à jour avec succès.',
            'data' => $produit
        ], 200);
    }

    /**
     * Supprime un produit spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $produit->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès.'
        ], 200); // Changer à 204 si vous ne voulez pas inclure un corps dans la réponse
    }
}
