E-Commerce (Concurrency & Scalability Playground)

مشروع متجر إلكتروني بسيط، لكن الهدف الأساسي منه ليس بيع المنتجات، بل هو بيئة تدريب وتطبيق لمفاهيم البرمجة التفرعية (Concurrent Programming) ومعالجة ضغط الطلبات (Scalability) باستخدام Laravel 12.

🛡️ المفاهيم المطبقة حالياً:

 1. Race Condition Prevention: منع تكرار الطلبات على نفس المنتج باستخدام Pessimistic Locking (lockForUpdate).
 2. Clean Architecture: فصل المسارات (Routes)، التحقق (Form Requests)، والمنطق (Controllers).
 3. Load Testing: سكربتات بلغة PHP لضغط نقطة النهاية بـ 50 طلب متزامن للتأكد من سلامة القفل.
 4. Database Indexing: إضافة فهارس (Indexes) لتحسين سرعة الاستعلامات على حالة الطلب.

🛠️ Tech Stack:

 1. Backend: Laravel 12 (PHP 8.2)
 2. Database: MySQL
 3. Testing: Custom PHP cURL Load Testing Scripts.

🚀 كيف تجرب المشروع:

composer install
نسخ .env.example إلى .env وتعديل بيانات قاعدة البيانات.
php artisan migrate
php artisan serve

تشغيل اختبار الضغط: 

php scripts/load_test.php

📌 ملاحظة:

هذا المشروع تحت التطوير المستمر، سيتم إضافة مفاهيم الـ Queues, Caching, وربما Microservices لاحقاً.

  