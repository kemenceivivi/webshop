<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\OrderedItem;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'kert',
        ]);

        Category::create([
            'name' => 'bútorok',
        ]);

        Category::create([
            'name' => 'ruházat',
        ]);
    }
}
