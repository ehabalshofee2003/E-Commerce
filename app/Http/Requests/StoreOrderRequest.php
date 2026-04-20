<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * تحديد من يسمح له بهذا الطلب (نجعلها true للجميع حالياً)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قواعد التحقق من البيانات
     */
    public function rules(): array
    {
        return [
            'user_id'    => 'required|integer|exists:users,id', // أضفنا هذا السطر
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            
            // أضف باقي الحقول اللي عندك في جدول الـ orders هنا
            // 'customer_name' => 'required|string|max:255',
            // 'customer_email' => 'required|email',
        ];
    }

    /**
     * رسائل الخطأ المخصصة (عربية)
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'حقل معرف المنتج مطلوب',
            'product_id.exists'   => 'المنتج المحدد غير موجود',
            'quantity.required'   => 'حقل الكمية مطلوب',
            'quantity.min'        => 'الكمية يجب أن تكون 1 على الأقل',
        ];
    }
}