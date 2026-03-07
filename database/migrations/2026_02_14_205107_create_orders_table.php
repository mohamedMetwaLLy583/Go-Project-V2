<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('nationality_id')->constrained()->onDelete('cascade');
            $table->boolean('accept_others_in_car')->default(false)->comment('هل تقبل أحد في السيارة؟');
            $table->boolean('accept_smoking')->default(false)->comment('هل تقبل تدخين السائق؟');
            $table->enum('car_specification', ['regular', 'separated'])->default('regular')->comment('مواصفات السيارة (عادية/مظللة)');
            $table->decimal('price', 10, 2)->comment('عرض السعر من المستخدم');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->decimal('distance_km', 10, 2)->nullable()->comment('عدد الكيلومترات');
            $table->decimal('app_commission', 10, 2)->nullable()->comment('عمولة التطبيق');
            $table->text('notes')->nullable();
            $table->boolean('is_urgent')->default(false)->comment('هل الطلب مستعجل؟');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
