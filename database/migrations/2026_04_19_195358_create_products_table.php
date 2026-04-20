<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 15, 2);
            
            // لماذا integer وليس decimal للمخزون؟
            // لأن عمليات الخصم (decrement) في قواعد البيانات تكون أسرع وأكثر أماناً (Atomic) 
            // عندما نتعامل مع أرقام صحيحة (Integer) بدلاً من الأرقام العشرية.
            $table->unsignedInteger('stock')->default(0);
            
            $table->timestamps();
        });
    }
};