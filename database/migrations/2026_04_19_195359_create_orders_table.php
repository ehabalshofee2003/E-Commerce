<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // العلاقات مع تحديد cascadeOnDelete
            // إذا حذف المستخدم، نحذف طلبه. (يختلف حسب سياسة النظام، لكنه مناسب هنا).
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            
            $table->unsignedInteger('quantity');
            $table->decimal('total_price', 15, 2);
            
            // حالة الطلب: pending (قيد المعالجة)، paid (مدفوع)، failed (فشل)
            $table->string('status')->default('pending');
            
            $table->timestamps();

            // Adding Index: هذا الـ Index سر من أسرار الـ Scalability.
            // بدونه، لو بحثت عن الطلبات المعلقة في لوحة التحكم، سيقوم السيرفر بفحص الملايين من الصفوف (Full Table Scan)
            // مع الـ Index، سيجدها في أجزاء من الثانية.
            $table->index(['status', 'created_at']);
        });
    }
};