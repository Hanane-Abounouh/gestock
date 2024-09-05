<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     
Run the database seeds.*
@return void*/
public function run(){Category::create(['name' => 'Technology','description' => 'Everything related to tech gadgets and innovation']);

        Category::create([
            'name' => 'Science',
            'description' => 'Latest updates and discoveries in science'
        ]);

        Category::create([
            'name' => 'Books',
            'description' => 'Category for book enthusiasts'
        ]);
    }
}
