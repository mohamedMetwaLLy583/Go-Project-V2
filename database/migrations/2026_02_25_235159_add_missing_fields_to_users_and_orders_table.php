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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('wallet_balance', 10, 2)->default(0)->after('coins');
            $table->decimal('average_rating', 3, 2)->default(0)->after('wallet_balance');
            $table->boolean('accept_smoking')->default(false)->after('type')->comment('For drivers: accepts smoking');
            $table->boolean('accept_others')->default(false)->after('accept_smoking')->comment('For drivers: allows other passengers (mixing)');
            $table->enum('car_type', ['regular', 'separated'])->default('regular')->after('accept_others')->comment('For drivers: vehicle type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('selected_driver_id')->nullable()->after('user_id')->index();
            $table->timestamp('cancelled_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['wallet_balance', 'accept_smoking', 'accept_others', 'car_type']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['selected_driver_id']);
            $table->dropColumn(['selected_driver_id', 'cancelled_at']);
        });
    }
};
