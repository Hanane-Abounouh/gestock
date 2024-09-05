<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Récupère toutes les catégories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Récupère toutes les catégories de la base de données
            $categories = Category::all();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourne une réponse JSON avec un message d'erreur
            return response()->json(['message' => 'Une erreur est survenue lors de la récupération des catégories.'], 500);
        }
    }

    /**
     * Crée une nouvelle catégorie.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation des données reçues dans la requête
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            // Création d'une nouvelle catégorie avec les données validées
            $category = Category::create($validated);
            return response()->json([
                'message' => 'La catégorie a été créée avec succès.',
                'category' => $category
            ], 201);
        } catch (\Exception $e) {
            // En cas d'erreur, retourne une réponse JSON avec un message d'erreur
            return response()->json(['message' => 'Une erreur est survenue lors de la création de la catégorie.'], 500);
        }
    }

    /**
     * Affiche une catégorie spécifique par son ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Recherche de la catégorie par son ID
        $category = Category::find($id);

        if (!$category) {
            // Si la catégorie n'est pas trouvée, retourne une réponse JSON avec un message d'erreur
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        return response()->json($category, 200);
    }

    /**
     * Met à jour une catégorie existante.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Recherche de la catégorie par son ID
        $category = Category::find($id);

        if (!$category) {
            // Si la catégorie n'est pas trouvée, retourne une réponse JSON avec un message d'erreur
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        // Validation des données reçues dans la requête
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            // Mise à jour de la catégorie avec les données validées
            $category->update($validated);
            return response()->json([
                'message' => 'La catégorie a été mise à jour avec succès.',
                'category' => $category
            ], 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourne une réponse JSON avec un message d'erreur
            return response()->json(['message' => 'Une erreur est survenue lors de la mise à jour de la catégorie.'], 500);
        }
    }

    /**
     * Supprime une catégorie par son ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Recherche de la catégorie par son ID
        $category = Category::find($id);

        if (!$category) {
            // Si la catégorie n'est pas trouvée, retourne une réponse JSON avec un message d'erreur
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        try {
            // Suppression de la catégorie
            $category->delete();
            return response()->json(['message' => 'La catégorie a été supprimée avec succès.'], 204);
        } catch (\Exception $e) {
            // En cas d'erreur, retourne une réponse JSON avec un message d'erreur
            return response()->json(['message' => 'Une erreur est survenue lors de la suppression de la catégorie.'], 500);
        }
    }
}
