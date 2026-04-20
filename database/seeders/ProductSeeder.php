<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // إنشاء منتج واحد، بسعر 100، والمخزون يساوي 1 فقط!
        // هذا الإعداد المصنوع بعناية هو الذي سيكشف لنا الـ Race Condition لاحقاً.
        Product::create([
            'name' => 'Limited Edition Gaming Mouse',
            'price' => 100.00,
            'stock' => 5, 
        ]);

        // إعطاء أول مستخدم في النظام رصيد 500 لكي يتمكن من الشراء
        // (لأننا سنجبر الـ API على استخدام هذا المستخدم لاحقاً أثناء الاختبار)
        if (User::count() > 0) {
            User::first()->update(['balance' => 500.00]);
        }
    }
}