<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('neighborhood_id')->constrained()->onDelete('cascade');
            $table->foreignId('day_id')->constrained()->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // لمنع تكرار نفس الفترة لنفس السائق في نفس الحي واليوم
            $table->unique(['driver_id', 'neighborhood_id', 'day_id', 'start_time'], 'unique_schedule');
            
            // فهارس للبحث السريع
            $table->index('driver_id');
            $table->index('neighborhood_id');
            $table->index('day_id');
            $table->index(['day_id', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_availability');
    }
};