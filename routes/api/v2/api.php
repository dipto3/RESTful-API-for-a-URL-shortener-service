<?php


use App\Http\Controllers\Api\V2\ShortenUrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Version-2 API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v2')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/shorten-url', [ShortenUrlController::class, 'store']);
        Route::get('/url-lists', [ShortenUrlController::class, 'list']);

      
    });
});
