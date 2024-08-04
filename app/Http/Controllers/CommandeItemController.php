<?php
namespace App\Http\Controllers;

use App\Models\CommandeItem;
use Illuminate\Http\Request;
use Exception;

class CommandeItemController extends Controller
{
    public function index()
    {
        try {
            $commandeItems = CommandeItem::with('commande', 'produit')->get();
            return response()->json([
                'message' => 'Liste de tous les éléments de commande récupérée avec succès.',
                'data' => $commandeItems
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        return view('commande_items.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'commande_id' => 'required|exists:commandes,id',
                'produit_id' => 'required|exists:produits,id',
                'quantite' => 'required|integer',
                'prix' => 'required|numeric',
            ]);

            $commandeItem = CommandeItem::create($validatedData);
            return response()->json([
                'message' => 'Élément de commande créé avec succès.',
                'data' => $commandeItem
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(CommandeItem $commandeItem)
    {
        try {
            $commandeItem->load('commande', 'produit');
            return response()->json([
                'message' => 'Détails de l\'élément de commande récupérés avec succès.',
                'data' => $commandeItem
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(CommandeItem $commandeItem)
    {
        return view('commande_items.edit', compact('commandeItem'));
    }

    public function update(Request $request, CommandeItem $commandeItem)
    {
        try {
            $validatedData = $request->validate([
                'commande_id' => 'required|exists:commandes,id',
                'produit_id' => 'required|exists:produits,id',
                'quantite' => 'required|integer',
                'prix' => 'required|numeric',
            ]);

            $commandeItem->update($validatedData);
            return response()->json([
                'message' => 'Élément de commande mis à jour avec succès.',
                'data' => $commandeItem
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(CommandeItem $commandeItem)
    {
        try {
            $commandeItem->delete();
            return response()->json([
                'message' => 'Élément de commande supprimé avec succès.'
            ], 200); // Changer à 204 si vous ne voulez pas inclure un corps dans la réponse
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
