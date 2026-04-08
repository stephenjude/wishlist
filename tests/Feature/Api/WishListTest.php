<?php

use App\Models\Product;
use App\Models\User;
use App\Models\WishList;
use Laravel\Sanctum\Sanctum;

describe('WishList', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->product = Product::factory()->create();
    });

    describe('GET /api/wishlist', function () {
        it('returns authenticated user wishlist', function () {
            $this->user->wishlist()->attach($this->product->id);

            Sanctum::actingAs($this->user);

            $this->getJson('/api/wishlist')
                ->assertSuccessful()
                ->assertJsonStructure([
                    'data' => ['*' => ['id', 'name', 'description', 'price', 'created_at', 'updated_at']],
                    'meta' => ['current_page', 'per_page', 'total', 'last_page', 'next_page_url', 'prev_page_url'],
                ]);
        });

        it('returns 401 for unauthenticated request', function () {
            $this->getJson('/api/wishlist')->assertUnauthorized();
        });
    });

    describe('POST /api/wishlist/add', function () {
        it('adds product to wishlist', function () {
            Sanctum::actingAs($this->user);

            $this->postJson('/api/wishlist/add', ['product_id' => $this->product->id])
                ->assertSuccessful()
                ->assertStatus(201)
                ->assertJson(['message' => 'Product added to wishlist']);

            $this->assertDatabaseHas(WishList::class, [
                'user_id' => $this->user->id,
                'product_id' => $this->product->id,
            ]);
        });

        it('returns 409 when product already in wishlist', function () {
            $this->user->wishlist()->attach($this->product->id);

            Sanctum::actingAs($this->user);

            $this->postJson('/api/wishlist/add', ['product_id' => $this->product->id])
                ->assertStatus(409)
                ->assertJson(['message' => 'Product already in wishlist']);
        });

        it('returns 401 for unauthenticated request', function () {
            $this->postJson('/api/wishlist/add', ['product_id' => $this->product->id])
                ->assertUnauthorized();
        });
    });

    describe('DELETE /api/wishlist/remove', function () {
        it('removes product from wishlist', function () {
            $this->user->wishlist()->attach($this->product->id);

            Sanctum::actingAs($this->user);

            $this->deleteJson('/api/wishlist/remove', ['product_id' => $this->product->id])
                ->assertSuccessful()
                ->assertJson(['message' => 'Product removed from wishlist']);

            $this->assertDatabaseMissing(WishList::class, [
                'user_id' => $this->user->id,
                'product_id' => $this->product->id,
            ]);
        });

        it('returns 404 when product not in wishlist', function () {
            Sanctum::actingAs($this->user);

            $this->deleteJson('/api/wishlist/remove', ['product_id' => $this->product->id])
                ->assertStatus(404)
                ->assertJson(['message' => 'Product not found in wishlist']);
        });

        it('returns 401 for unauthenticated request', function () {
            $this->deleteJson('/api/wishlist/remove', ['product_id' => $this->product->id])
                ->assertUnauthorized();
        });
    });
});
