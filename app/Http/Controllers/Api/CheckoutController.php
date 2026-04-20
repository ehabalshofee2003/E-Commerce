<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /*هذا الكود خاطئ لأنه لا يستخدم المعاملات (Transactions) ولا الأقفال (Locks) مما يؤدي إلى حدوث مشكلة    
   */
    public function checkout(Request $request)
    {
        // لتبسيط الاختبار، سنستخدم أول مستخدم في النظام (الذي رصيده 500)
        $user = User::first();
        $productId = 1; // المنتج الوحيد الذي مخزونه 1
        
        // ================= 🚨 الكود الخاطئ (Race Condition) =================
        
        // 1. القراءة (Read)
        $product = Product::find($productId);
        
        // 2. الفحص (Check)
        if ($product->stock < 1) {
            return response()->json(['message' => 'Out of stock'], 400);
        }

        if ($user->balance < $product->price) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        // 3. التعديل (Modify)
        $user->balance -= $product->price;
        $product->stock -= 1;
        
        // 4. الكتابة (Write)
        $user->save();
        $product->save();
        
        // إنشاء الطلب
        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'quantity' => 1,
            'total_price' => $product->price,
            'status' => 'paid'
        ]);

        return response()->json(['message' => 'Purchase successful', 'order_id' => $order->id], 201);
    }
    
}