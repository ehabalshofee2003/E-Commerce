<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // السماح بملء هذه الحقول بشكل مباشر
    protected $fillable = ['name', 'price', 'stock'];

    // Casts: تحويل أنواع البيانات عند القراءة من قاعدة البيانات
    // هذا يحمينا من أن تتعامل PHP مع الرقم كانها String فتحدث عمليات مقارنة خاطئة.
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];
}