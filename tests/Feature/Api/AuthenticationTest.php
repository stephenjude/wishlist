<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

describe('Authentication', function () {
    describe('POST /api/register', function () {
        it('registers a new user successfully', function () {
            $requestData = [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $this->postJson('/api/register', $requestData)
                ->assertSuccessful()
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                    ],
                ]);

            $this->assertDatabaseHas('users', [
                'name' => $requestData['name'],
                'email' => $requestData['email'],
            ]);
        });

        it('fails registration with invalid registration data', function () {
            $data = [
                'name' => null,
                'email' => 'invalid-email',
                'password' => 'password123',
                'password_confirmation' => 'different',
            ];

            $this->postJson('/api/register', $data)
                ->assertUnprocessable()
                ->assertJsonValidationErrors([
                    'name',
                    'email',
                    'password',
                ]);
        });
    });

    describe('POST /api/login', function () {
        it('logs in a user with valid credentials', function () {
            $requestData = [
                'email' => 'john@example.com',
                'password' => 'password123',
            ];

            User::factory()->create($requestData);

            $this->postJson('/api/login', $requestData)
                ->assertSuccessful()
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                    ],
                    'meta' => ['api_token'],
                ]);
        });

        it('fails login with invalid email or password', function () {
            $requestData = [
                'email' => 'nonexistent@example.com',
                'password' => 'wrongpassword',
            ];

            $this->postJson('/api/login', $requestData)
                ->assertUnauthorized()
                ->assertJson(['message' => 'Invalid credentials']);
        });
    });

    describe('POST /api/logout', function () {
        beforeEach(function () {
            $this->user = User::factory()->create();
        });

        it('logs out the authenticated user', function () {
            Sanctum::actingAs($this->user);

            $this->postJson('/api/logout')
                ->assertSuccessful()
                ->assertJson(['message' => 'Logged out successfully']);
        });

        it('returns 401 for unauthenticated request', function () {
            $this->postJson('/api/logout')
                ->assertUnauthorized();
        });
    });
});
