<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeItemsTable extends Migration
{
    public function up()
    {
        Schema::create('commande_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->integer('quantite'); // quantité
            $table->decimal('prix', 10, 2); // prix
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commande_items');
    }
}
