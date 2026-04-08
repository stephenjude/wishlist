<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WishList>
 */
class WishListFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
