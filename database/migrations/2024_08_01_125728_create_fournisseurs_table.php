<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFournisseursTable extends Migration
{
    public function up()
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id(); // identifiant unique
            $table->string('nom'); // nom du fournisseur
            $table->text('informations_contact')->nullable(); // informations de contact
            $table->timestamps(); // colonnes created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('fournisseurs');
    }
}
