<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('orders')->delete();
       Order::create([
            'user_id' => 1,
            'address' => 'null',
            'comment' => 'null',
            'payment_method'=>'CASH',
            'status'=>'CART',
        ]);

        Order::create([
            'user_id' => 2,
            'address' => 'null',
            'comment' => 'null',
            'payment_method'=>'CASH',
            'status'=>'REJECTED',
        ]);

        Order::create([
            'user_id' => 1,
            'address' => 'null',
            'comment' => 'null',
            'payment_method'=>'CASH',
            'status'=>'RECEIVED',
        ]);

    }
}
