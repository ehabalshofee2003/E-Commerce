<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/orders', [OrderController::class, 'store']);