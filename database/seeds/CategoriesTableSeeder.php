<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Ideas','On Going','Completed'];

        foreach($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
