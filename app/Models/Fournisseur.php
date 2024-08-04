<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'informations_contact'];

    public function produits()
    {
        return $this->hasMany(Product::class, 'fournisseur_id');
    }
}
