<?php
namespace App\Http\Controllers;

use App\Models\Inventaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventaireController extends Controller
{
    public function index()
    {
        try {
            $inventaires = Inventaire::with('produit')->get();
            return response()->json(['message' => 'Inventaires récupérés avec succès', 'data' => $inventaires], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des inventaires: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la récupération des inventaires'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'currentStock' => 'required|integer',
        ]);

        try {
            $inventaire = Inventaire::create($request->all());
            return response()->json(['message' => 'Inventaire créé avec succès', 'data' => $inventaire], 201);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'inventaire: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la création de l\'inventaire'], 500);
        }
    }

    public function show($id)
    {
        try {
            $inventaire = Inventaire::with('produit')->findOrFail($id);
            return response()->json(['message' => 'Inventaire récupéré avec succès', 'data' => $inventaire], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de l\'inventaire: ' . $e->getMessage());
            return response()->json(['message' => 'Inventaire non trouvé'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'produit_id' => 'exists:produits,id',
            'quantite' => 'integer',
            'location' => 'string|max:255',
            'capacity' => 'integer',
            'currentStock' => 'integer',
        ]);

        try {
            $inventaire = Inventaire::findOrFail($id);
            $inventaire->update($request->all());
            return response()->json(['message' => 'Inventaire mis à jour avec succès', 'data' => $inventaire], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'inventaire: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la mise à jour de l\'inventaire'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $inventaire = Inventaire::findOrFail($id);
            $inventaire->delete();
            return response()->json(['message' => 'Inventaire supprimé avec succès'], 204);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'inventaire: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la suppression de l\'inventaire'], 500);
        }
    }
}
