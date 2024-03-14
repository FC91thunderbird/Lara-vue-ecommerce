<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// home
Route::group([], function(){
    Route::get('/category_products', [HomeController::class, 'getCategoryAndProducts']);

    // Route::get('/cart', [CartController::class, 'index']);
    // Route::put('/cart/{cart}', [CartController::class, 'update']);
    // Route::delete('/cart/{product}', [CartController::class, 'destroy']);
    
    Route::post('/cart/{product}', [CartController::class, 'store']);
    Route::apiResource('/cart', CartController::class);

    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');

    Route::post('/register', [AuthController::class,'register']);
});

Route::group(['middleware'=> 'auth:sanctum'], function(){
    Route::get('/user', [AuthController::class, 'getUserDetails']);
    
    Route::post('/logout', [AuthController::class,'logout']);
});

Route::post('/login', [AuthController::class,'login']);

Route::group(['prefix'=> 'admin', 'middleware'=> 'auth:sanctum'], function(){
    Route::post('/category/{category}', [CategoryController::class, 'update']);
    Route::apiResource('/category', CategoryController::class);

    Route::post('/subcategory/{subcategory}', [SubcategoryController::class, 'update']);
    Route::get('/subcategory/{category}/fetch', [SubcategoryController::class, 'fetchSubcategory']);
    Route::apiResource('/subcategory', SubcategoryController::class);

    Route::post('/products/{products}', [ProductController::class, 'update']);
    Route::apiResource('/products', ProductController::class);

});