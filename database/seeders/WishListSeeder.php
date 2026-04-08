<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Database\Seeder;

class WishListSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            return;
        }

        $products = Product::inRandomOrder()->take(3)->get();

        foreach ($products as $product) {
            WishList::firstOrCreate([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
    }
}
