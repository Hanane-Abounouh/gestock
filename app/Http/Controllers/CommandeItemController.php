<?php
namespace App\Http\Controllers;

use App\Models\CommandeItem;
use Illuminate\Http\Request;

class CommandeItemController extends Controller
{
    public function index()
    {
        $commandeItems = CommandeItem::with('commande', 'produit')->get();
        return view('commande_items.index', compact('commandeItems'));
    }

    public function create()
    {
        return view('commande_items.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
        ]);

        CommandeItem::create($validatedData);
        return redirect()->route('commande_items.index')->with('success', 'Élément de commande créé avec succès.');
    }

    public function show(CommandeItem $commandeItem)
    {
        return view('commande_items.show', compact('commandeItem'));
    }

    public function edit(CommandeItem $commandeItem)
    {
        return view('commande_items.edit', compact('commandeItem'));
    }

    public function update(Request $request, CommandeItem $commandeItem)
    {
        $validatedData = $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
        ]);

        $commandeItem->update($validatedData);
        return redirect()->route('commande_items.index')->with('success', 'Élément de commande mis à jour avec succès.');
    }

    public function destroy(CommandeItem $commandeItem)
    {
        $commandeItem->delete();
        return redirect()->route('commande_items.index')->with('success', 'Élément de commande supprimé avec succès.');
    }
}
