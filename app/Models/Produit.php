<?php
// app/Models/Produit.php
// app/Models/Produit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'nom', 'categorie_id', 'fournisseur_id', 'quantite', 'prix'
    ];

    // Relation avec le modèle Categorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    // Relation avec le modèle Fournisseur
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
}
