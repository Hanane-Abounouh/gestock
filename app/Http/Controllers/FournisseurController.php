<?php
namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        return Fournisseur::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'informations_contact' => 'nullable|string',
        ]);

        $fournisseur = Fournisseur::create($validated);

        return response()->json($fournisseur, 201);
    }

    public function show(Fournisseur $fournisseur)
    {
        return $fournisseur;
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'informations_contact' => 'nullable|string',
        ]);

        $fournisseur->update($validated);

        return response()->json($fournisseur, 200);
    }

    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();

        return response()->json(null, 204);
    }
}
