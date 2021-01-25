<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Integer;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderedItem;
use Carbon\Carbon;
use Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ItemSeeder::class);

        DB::table('users')->truncate();

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@szerveroldali.hu',
            'password' => Hash::make('password'),
            'is_admin' => True,
        ]);

        $user = User::create([
            'name' => 'user1',
            'email' => 'user1@szerveroldali.hu',
            'password' => Hash::make('password'),
            'is_admin' => False,
        ]);

        $this->call(OrderSeeder::class);
        $this->call(OrderedItemSeeder::class);    
        $this->call(CategorySeeder::class); 

        Item::all()->each(function ($item) {
            $ids = Category::all()->random(rand(1,Category::count()))->pluck
            ('id')->toArray();
            $item->categories()->attach($ids);

        });

        

    }
}
