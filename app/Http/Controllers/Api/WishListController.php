<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishListRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = $request->user()->wishlist()->paginate();

        return response()->json([
            'data' => ProductResource::collection($products->items()),
            'meta' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
            ],
        ]);
    }

    public function store(WishListRequest $request): JsonResponse
    {
        $user = $request->user();

        if ($user->existsInWishlist($request->product_id)) {
            return response()->json([
                'message' => 'Product already in wishlist',
            ], 409);
        }

        $user->wishlist()->attach($request->product_id);

        return response()->json([
            'message' => 'Product added to wishlist',
        ], 201);
    }

    public function destroy(WishListRequest $request): JsonResponse
    {
        $user = $request->user();

        if (! $user->existsInWishlist($request->product_id)) {
            return response()->json([
                'message' => 'Product not found in wishlist',
            ], 404);
        }

        $user->wishlist()->detach($request->product_id);

        return response()->json([
            'message' => 'Product removed from wishlist',
        ]);
    }
}
