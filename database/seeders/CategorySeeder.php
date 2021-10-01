<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'cat 1', 'parent_id' => 0],
            ['name' => 'cat 2', 'parent_id' => 0],
            ['name' => 'cat sub 1 1 2', 'parent_id' => 22],
            ['name' => 'cat sub 3 1 1 1', 'parent_id' => 6],
            ['name' => 'cat sub 2 1', 'parent_id' => 2],
            ['name' => 'cat sub 3 1 1', 'parent_id' => 9],
            ['name' => 'cat sub 1 1 1', 'parent_id' => 22],
            ['name' => 'cat 4', 'parent_id' => 0],
            ['name' => 'cat sub 3 1', 'parent_id' => 15],
            ['name' => 'cat sub 1 1 2 1', 'parent_id' => 3],
            ['name' => 'cat sub 1 1 2 1 1 1', 'parent_id' => 21],
            ['name' => 'cat sub 1 2', 'parent_id' => 1],
            ['name' => 'cat sub 4 1', 'parent_id' => 8],
            ['name' => 'cat sub 2 2 1', 'parent_id' => 16],
            ['name' => 'cat 3', 'parent_id' => 0],
            ['name' => 'cat sub 2 2', 'parent_id' => 2],
            ['name' => 'cat sub 3 2', 'parent_id' => 15],
            ['name' => 'cat sub 4 2 1', 'parent_id' => 19],
            ['name' => 'cat sub 4 2', 'parent_id' => 8],
            ['name' => 'cat sub 4 2 1 1', 'parent_id' => 18],
            ['name' => 'cat sub 1 1 2 1 1', 'parent_id' => 10],
            ['name' => 'cat sub 1 1', 'parent_id' => 1]
        ];

        foreach($categories as $value){
            Category::create($value);
        }
    }
}
