E-Commerce (Concurrency & Scalability Playground)

مشروع متجر إلكتروني بسيط، لكن الهدف الأساسي منه ليس بيع المنتجات، بل هو بيئة تدريب وتطبيق لمفاهيم البرمجة التفرعية (Concurrent Programming) ومعالجة ضغط الطلبات (Scalability) باستخدام Laravel 12.

🛡️ المفاهيم المطبقة حالياً:
Race Condition Prevention: منع تكرار الطلبات على نفس المنتج باستخدام Pessimistic Locking (lockForUpdate).
Clean Architecture: فصل المسارات (Routes)، التحقق (Form Requests)، والمنطق (Controllers).
Load Testing: سكربتات بلغة PHP لضغط نقطة النهاية بـ 50 طلب متزامن للتأكد من سلامة القفل.
Database Indexing: إضافة فهارس (Indexes) لتحسين سرعة الاستعلامات على حالة الطلب.
🛠️ Tech Stack:
Backend: Laravel 12 (PHP 8.2)
Database: MySQL
Testing: Custom PHP cURL Load Testing Scripts.
🚀 كيف تجرب المشروع:
composer install
نسخ .env.example إلى .env وتعديل بيانات قاعدة البيانات.
php artisan migrate
php artisan serve
تشغيل اختبار الضغط: php scripts/load_test.php
📌 ملاحظة:
هذا المشروع تحت التطوير المستمر، سيتم إضافة مفاهيم الـ Queues, Caching, وربما Microservices لاحقاً.

