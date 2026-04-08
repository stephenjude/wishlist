<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('dd', function () {
    $this->comment('Dumping some data for testing purposes...');

    Http::baseUrl('https://wishlist.test')
        ->acceptJson()
        ->post('api/register', [
            'name' => 'Test User',
            'email' => fake()->unique()->email(),
            'password' => $password = Str::random(10),
            'password_confirmation' => $password,
        ])
        ->collect()
        ->dd()
        ->post('api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ])
        ->dd();
})->purpose('Playground for testing dd()');
