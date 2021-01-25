<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderedItem;

class OrderedItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('ordered_items')->delete();
        OrderedItem::create([
            'item_id' => 4,
            'order_id' => 1,
            'quantity' => 4
        ]);

        OrderedItem::create([
            'item_id' => 1,
            'order_id' => 1,
            'quantity' => 15
        ]);

        OrderedItem::create([
            'item_id' => 2,
            'order_id' => 2,
            'quantity' => 3
        ]);

        OrderedItem::create([
            'item_id' => 3,
            'order_id' => 2,
            'quantity' => 1
        ]);

        OrderedItem::create([
            'item_id' => 1,
            'order_id' => 3,
            'quantity' => 10
        ]);
    }
}
