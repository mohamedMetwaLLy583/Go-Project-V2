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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('product_id');
            $table->string('purchase_id');
            $table->string('purchase_token')->unique();
            $table->string('title')->default('شحن رصيد');
            $table->integer('coins');
            $table->integer('price');
            $table->enum('status', ['pending', 'paid', 'refunded', 'canceled', 'failed'])->default('pending');
            $table->timestamp('date')->useCurrent();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
