<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('items')->delete();
        Item::create([
            'name' => 'Semmi',
            'description' => 'Vadonatúj semmi',
            'price' => 50
        ]);

        Item::create([
            'name' => 'Valami',
            'description' => 'Valami hasznos',
            'price' => 70
        ]);

        Item::create([
            'name' => 'FENDER SQUIER Bronco Bass MN BK',
            'image_url' => 'LELK0FOjhW6SOzlNbn5gSAG0BnmcOjDVPVHcAKpR.jpeg',
            'description' => 'Elektromos basszusgitár',
            'price' => 100
        ]);

        Item::create([
            'name' => 'Asd',
            'description' => 'Kicsi asd',
            'price' => 200
        ]);

        Item::create([
            'name' => 'Fekete Vans',
            'description' => 'Fekete Vans cipő',
            'image_url' => '26185_500_A.jpg',
            'price' => 200
        ]);
    }
}
