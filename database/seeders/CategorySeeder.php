<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::create([
            'name' => 'Štapovi',
            'slug' => 'stapovi',
            'description' => 'Ribolovni štapovi.'
        ]);

        $category->id = 1;
        $category->save();

        $category = Category::create([
            'name' => 'Varalice',
            'slug' => 'varalice',
            'description' => 'Varalice za ribolov.'
        ]);

        $category->id = 2;
        $category->save();

        $category = Category::create([
            'name' => 'Najloni',
            'slug' => 'najloni',
            'description' => 'Najloni za ribolov.'
        ]);

        $category->id = 3;
        $category->save();
    }
}
