<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Affiche la liste de tous les clients.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Récupère tous les clients
        $clients = Client::all();
        
        // Retourne les clients avec un message de succès
        return response()->json([
            'message' => 'Liste de tous les clients récupérée avec succès.',
            'data' => $clients
        ], 200);
    }

    /**
     * Crée un nouveau client.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation des données envoyées dans la requête
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
        ]);

        // Création du client
        $client = Client::create($validated);

        // Retourne le client créé avec un message de succès
        return response()->json([
            'message' => 'Client créé avec succès.',
            'data' => $client
        ], 201);
    }

    /**
     * Affiche les détails d'un client spécifique.
     *
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Client $client)
    {
        // Retourne les détails du client avec un message de succès
        return response()->json([
            'message' => 'Détails du client récupérés avec succès.',
            'data' => $client
        ], 200);
    }

    /**
     * Met à jour les informations d'un client spécifique.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Client $client)
    {
        // Validation des données envoyées dans la requête
        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:clients,email,' . $client->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
        ]);

        // Mise à jour des informations du client
        $client->update($validated);

        // Retourne le client mis à jour avec un message de succès
        return response()->json([
            'message' => 'Client mis à jour avec succès.',
            'data' => $client
        ], 200);
    }

    /**
     * Supprime un client spécifique.
     *
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $client)
    {
        // Suppression du client
        $client->delete();

        // Retourne un message de succès pour la suppression
        return response()->json([
            'message' => 'Client supprimé avec succès.'
        ], 200);
    }
}
