<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;


Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);

Route::get('/carts', [CartController::class, 'index']);
Route::post('/carts', [CartController::class, 'store']);
Route::delete('/carts/{id}', [CartController::class, 'destroy']);

Route::get('/wishlists', [WishlistController::class, 'index']);
Route::post('/wishlists', [WishlistController::class, 'store']);
Route::delete('/wishlists/{id}', [WishlistController::class, 'destroy']);

Route::post('/orders', [OrderController::class, 'store']);
Route::post('/xendit/webhook', [OrderController::class, 'webhook']);
Route::get('/orders', [OrderController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);