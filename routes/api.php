<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/orders', [OrderController::class, 'store']);


// ==========================================
// المتطلب الثاني: إدارة الموارد ومنع الانهيار (Rate Limiting)
// ==========================================
// throttle:10,1 تعني: السماح بـ 10 طلبات كحد أقصى لكل دقيقة (1 minute) لكل IP
Route::post('/orders/protected', [OrderController::class, 'store'])
    ->middleware('throttle:10,1'); 