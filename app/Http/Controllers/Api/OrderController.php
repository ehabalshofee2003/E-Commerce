<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * إنشاء طلب شراء جديد (محمي من Race Condition)
     */
public function store(StoreOrderRequest $request): JsonResponse
{
    return DB::transaction(function () use ($request) {
        
        $product = Product::where('id', $request->product_id)
                          ->lockForUpdate()
                          ->first();

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية غير متوفرة! المتبقي: ' . $product->stock
            ], 400);
        }

        $order = Order::create([
            'user_id'     => $request->user_id, // أضفنا الـ user_id
            'product_id'  => $request->product_id,
            'quantity'    => $request->quantity,
            'total_price' => $product->price * $request->quantity, // حسبنا السعر الإجمالي
            // status ماعديناه لأن الداتابيز حاطه default تلقائي (pending)
        ]);

        $product->decrement('stock', $request->quantity);

        return response()->json([
            'success'  => true,
            'message'  => 'تم إنشاء الطلب بنجاح',
            'order_id' => $order->id,
        ], 201);

    });
}
}