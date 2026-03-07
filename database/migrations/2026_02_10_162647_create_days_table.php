<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('short_name_ar', 10)->nullable();
            $table->string('short_name_en', 10)->nullable();
            $table->tinyInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('days');
    }
};