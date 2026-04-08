<?php

use App\Models\Product;

describe('Products', function () {
    describe('GET /api/products', function () {
        it('returns products with pagination', function () {
            Product::factory()->count(20)->create();

            $this->getJson('/api/products')
                ->assertSuccessful()
                ->assertJsonStructure([
                    'data' => ['*' => ['id', 'name', 'description', 'price', 'created_at', 'updated_at']],
                    'meta' => ['current_page', 'per_page', 'total', 'last_page', 'next_page_url', 'prev_page_url'],
                ])
                ->assertJsonPath('meta.current_page', 1)
                ->assertJsonPath('meta.per_page', 15);
        });
    });
});
