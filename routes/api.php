<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\AssignProductController;
use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Public routes
Route::get('/products', [ProductController::class, 'index']);

// Token creation route
Route::post('/tokens/create', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken
    ]);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', StoreProductController::class);
    Route::post('/engineers/{engineer}/products', AssignProductController::class);
});