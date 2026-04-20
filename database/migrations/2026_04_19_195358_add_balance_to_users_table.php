<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // سر الأداء هنا: استخدام decimal وليس float أو double.
            // في الأنظمة المالية، float يسبب أخطاء تقريب (Rounding Errors) تؤدي لفقدان أموال!
            $table->decimal('balance', 15, 2)->default(0)->after('email');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
};