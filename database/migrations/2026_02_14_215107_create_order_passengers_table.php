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
        Schema::create('order_passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['male', 'female', 'child', 'elderly']);
            $table->timestamp('pickup_time');
            $table->timestamp('return_time');
            $table->string('pickup_location');
            $table->string('return_location');
            // log , lat
            $table->string('pickup_lat');
            $table->string('pickup_lng');
            $table->string('return_lat');
            $table->string('return_lng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_passengers');
    }
};
