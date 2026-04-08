<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Electric Toothbrush',
                'description' => 'Sonic electric toothbrush with 3 cleaning modes and 2-minute timer.',
                'price' => 79.99,
            ],
            [
                'name' => 'Whitening Toothpaste',
                'description' => 'Enamel-safe whitening toothpaste with fluoride for daily use.',
                'price' => 8.99,
            ],
            [
                'name' => 'Dental Floss Set',
                'description' => 'Mint-flavored dental floss with expandable floss picks.',
                'price' => 12.99,
            ],
            [
                'name' => 'Mouthwash',
                'description' => 'Alcohol-free antiseptic mouthwash for fresh breath and gum health.',
                'price' => 6.99,
            ],
            [
                'name' => 'Water Flosser',
                'description' => 'Portable water flosser with 4 nozzles and 3 pressure settings.',
                'price' => 49.99,
            ],
            [
                'name' => 'Tongue Scraper',
                'description' => 'Stainless steel tongue scraper to remove bacteria and improve breath.',
                'price' => 9.99,
            ],
            [
                'name' => 'Orthodontic Wax',
                'description' => 'Dental wax kit for braces relief and comfort.',
                'price' => 5.49,
            ],
            [
                'name' => 'Interdental Brushes',
                'description' => 'Pack of 50 interdental brushes for braces and implants.',
                'price' => 14.99,
            ],
            [
                'name' => 'Night Guard',
                'description' => 'Custom-fit dental night guard for teeth grinding protection.',
                'price' => 34.99,
            ],
            [
                'name' => 'Toothbrush Holder',
                'description' => 'UV sanitizing toothbrush holder with 4 slots and air vent.',
                'price' => 24.99,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
