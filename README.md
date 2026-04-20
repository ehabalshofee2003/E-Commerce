# 🛒 HP E-Commerce: Concurrency & Scalability Playground

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
تنويه: هذا ليس متجراً إلكترونياً تقليدياً. هذا المشروع هو بيئة اختبار وتطبيق عملي لمفاهيم البرمجة التفرعية (Concurrent Programming)، وهدفه الأساسي هو حل المشاكل غير الوظيفية (Non-Functional Requirements) التي تواجه الأنظمة ذات الضغط العالي.

---

## 🎯 المشكلة والحل (المتطلبات غير الوظيفية)

تم بناء هذا المشروع لمعالجة وتطبيق متطلبين أساسيين في هندسة البرمجيات:

### 1. حماية البيانات المشتركة (Concurrent Access & Data Integrity)

**المشكلة (Race Condition):**  
عندما يحاول عدة مستخدمين شراء نفس المنتج في نفس اللحظة، قد يقرأ النظام المخزون المتاح كـ "1" لأكثر من مستخدم، مما يؤدي إلى بيع منتجات غير موجودة فعلياً (المخزون يصير سالباً).

**الحل:**  
استخدام Pessimistic Locking عبر `lockForUpdate()` داخل `DB::transaction`.  
هذا يقوم بقفل الصف (Row Lock) في قاعدة البيانات، لضمان أن طلباً واحداً فقط هو من يقرأ ويعدل المخزون في اللحظة المعينة.

---

### 2. إدارة الموارد الحاسوبية (Resource Management & Capacity Control)

**المشكلة (Resource Exhaustion):**  
إذا قام مهاجم أو خطأ برمجي بإرسال آلاف الطلبات في ثانية واحدة، سيحاول السيرفر فتح آلاف الاتصالات بقاعدة البيانات، مما يؤدي إلى استهلاك كامل للرامات (RAM) والمعالج (CPU) وانهيار النظام بالكامل (Crash).

**الحل:**  
استخدام Rate Limiting (عبر middleware `throttle`) للتحكم في معدل الطلبات، ورفض أي طلبات زائدة برسالة  
`429 Too Many Requests` لحماية موارد السيرفر.

---

## 🏗️ هندسة النظام (Clean Architecture)

تم فصل المسؤوليات بشكل كامل لضمان قابلية التوسع (Scalability):

- `Routes/api.php`: تعريف نقاط النهاية (Endpoints) فقط  
- `Controllers`: استقبال الطلب وتوجيهه (بدون أي منطق تجاري)  
- `FormRequests`: التحقق من صحة البيانات (Validation) خارج الـ Controller  
- `Database Transactions`: تنفيذ المنطق الحساس (القفل، الخصم، الحفظ) كمعاملة واحدة ذرية (Atomic)

---

## 🧪 إثبات العمل (Proof of Concept)

مشروع يحتوي على كلام نظري لا قيمة له. لذلك، قمت ببناء أدوات اختبار ضغط (Load Testing) مكتوبة بـ PHP cURL لإثبات فعالية الحلول:

### 🔹 الاختبار الأول: التحقق من منع التضارب (Race Condition)

- الأداة:  
```bash
php scripts/load_test.php

السيناريو:
إرسال 50 طلب شراء متزامن (في نفس الملي ثانية) لمنتج مخزونه 5 فقط.
النتيجة المتوقعة:
النظام يقبل 5 طلبات فقط، ويرفض الـ 45 طلب الباقي لتجنب المخزون السلبي
## 🔹 الاختبار الثاني: التحقق من إدارة الموارد (Rate Limiting)
- الأداة:
php scripts/load_test_resources.php
السيناريو:
إرسال 15 طلب سريع متتالي لنفس الـ IP.
النتيجة المتوقعة:
النظام يسمح بأول 10 طلبات، ويرد على الـ 5 الباقية بـ:
HTTP 429 Too Many Requests
## 🛠️ Tech Stack & Tools
- Backend Framework: Laravel 12
- Language: PHP 8.2
- Database: MySQL (مع استخدام Indexes لتحسين أداء الاستعلامات)
- Testing Tools: Custom cURL Multi-threading Scripts
## ⚠️ ملاحظة قبل اختبار الضغط
` تأكد من تحديث مخزون أحد المنتجات في قاعدة البيانات ليكون رقم صغير (مثل 5)،
` لكي تلاحظ فرض الرفض عند تشغيل سكربتات الاختبار في مجلد scripts.
## 📌 ملاحظة المطور
` هذا المشروع تحت التطوير المستمر كبيئة لتعلم مفاهيم الـ System Design والـ Backend Engineering.
