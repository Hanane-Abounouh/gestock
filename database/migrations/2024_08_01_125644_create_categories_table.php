<?php
// database/migrations/xxxx_xx_xx_create_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
       // Example migration for categories table
     Schema::create('categories', function (Blueprint $table) {
     $table->id();
     $table->string('name');
     $table->text('description')->nullable();
     $table->foreignId('user_id')->constrained()->onDelete('cascade');
     $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
