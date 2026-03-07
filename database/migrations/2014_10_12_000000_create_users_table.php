<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->integer('age');
            $table->foreignId('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->string('profile_picture')->nullable();
            $table->tinyInteger('type')->default(3); // 1: Admin, 2: driver, 3: user
            $table->integer('coins')->default(0);
            $table->integer('status')->default(1); // 1: active, 0: inactive
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
