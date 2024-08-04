<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventairesTable extends Migration
{
    public function up()
    {
        Schema::create('inventaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->integer('quantite');
            $table->string('location');
            $table->integer('capacity');
            $table->integer('currentStock');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventaires');
    }
}
