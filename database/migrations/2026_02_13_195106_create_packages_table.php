<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price'); // سعر الباقة
            $table->integer('coins'); // عدد العملات التي يحصل عليها المستخدم
            $table->integer('duration'); // المدة 
            $table->string('duration_unit')->default('month'); // وحدة المدة (month, year)
            $table->json('features')->nullable(); // مميزات الباقة (JSON)
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة الباقة
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->boolean('is_popular')->default(false); // هل الباقة مميزة
            $table->integer('investment_amount')->nullable(); // مبلغ الاستثمار (اختياري)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
};
