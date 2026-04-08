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
                'name' => 'Wireless Headphones',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life.',
                'price' => 199.99,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smart watch with heart rate monitor and GPS.',
                'price' => 299.99,
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Ergonomic aluminum laptop stand with adjustable height.',
                'price' => 49.99,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical keyboard with Cherry MX switches.',
                'price' => 129.99,
            ],
            [
                'name' => 'USB-C Hub',
                'description' => '7-in-1 USB-C hub with HDMI, USB 3.0, and SD card reader.',
                'price' => 59.99,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with silent clicks and long battery life.',
                'price' => 39.99,
            ],
            [
                'name' => 'Monitor Light Bar',
                'description' => 'LED monitor light bar with adjustable brightness and color temperature.',
                'price' => 69.99,
            ],
            [
                'name' => 'Webcam HD',
                'description' => '1080p HD webcam with auto-focus and built-in microphone.',
                'price' => 79.99,
            ],
            [
                'name' => 'Portable SSD',
                'description' => '500GB portable SSD with USB 3.2 and fast transfer speeds.',
                'price' => 89.99,
            ],
            [
                'name' => 'Desk Mat',
                'description' => 'Extended desk mat with stitched edges and water-resistant surface.',
                'price' => 24.99,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
