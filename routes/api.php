<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WishListController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/wishlist', [WishListController::class, 'index']);
    Route::post('/wishlist/add', [WishListController::class, 'store']);
    Route::delete('/wishlist/remove', [WishListController::class, 'destroy']);
});
