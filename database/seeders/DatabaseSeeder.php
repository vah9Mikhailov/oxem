<?php

namespace Database\Seeders;

use App\Models\Category\Entity\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class  DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(15)->create();
        // Product::factory(15)->create();
    }
}
