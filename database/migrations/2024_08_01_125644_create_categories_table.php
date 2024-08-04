<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // identifiant unique
            $table->string('nom'); // nom de la catégorie
            $table->text('description')->nullable(); // description de la catégorie
            $table->timestamps(); // colonnes created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
