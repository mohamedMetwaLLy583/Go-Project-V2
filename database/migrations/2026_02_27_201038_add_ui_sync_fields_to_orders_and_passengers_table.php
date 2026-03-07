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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('shift_type', ['fixed', 'variable'])->default('fixed')->after('status');
            $table->enum('trip_type', ['round_trip', 'go_only', 'return_only'])->default('round_trip')->after('shift_type');
            $table->json('delivery_days')->nullable()->after('trip_type');
            $table->json('vacation_days')->nullable()->after('delivery_days');
            $table->boolean('needs_ac')->default(true)->after('vacation_days');
            $table->boolean('tinted_glass')->default(false)->after('needs_ac');
            $table->enum('car_condition', ['standard', 'new'])->default('standard')->after('tinted_glass');
            $table->boolean('is_shared')->default(false)->after('car_condition');
            $table->decimal('salary', 10, 2)->nullable()->after('price');
            $table->date('start_date')->nullable()->after('salary');
            $table->integer('men_count')->default(0)->after('start_date');
            $table->integer('women_count')->default(0)->after('men_count');
            $table->integer('student_m_count')->default(0)->after('women_count');
            $table->integer('student_f_count')->default(0)->after('student_m_count');
        });

        Schema::table('order_passengers', function (Blueprint $table) {
            $table->string('pickup_neighborhood')->nullable()->after('pickup_location');
            $table->string('return_neighborhood')->nullable()->after('return_location');
            $table->enum('pickup_location_type', ['home', 'work', 'school'])->default('home')->after('pickup_neighborhood');
            $table->enum('return_location_type', ['home', 'work', 'school'])->default('work')->after('return_neighborhood');
            $table->time('driver_arrival_time')->nullable()->after('pickup_time');
            $table->time('work_start_time')->nullable()->after('driver_arrival_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shift_type', 'trip_type', 'delivery_days', 'vacation_days', 
                'needs_ac', 'tinted_glass', 'car_condition', 'is_shared', 
                'salary', 'start_date', 'men_count', 'women_count', 
                'student_m_count', 'student_f_count'
            ]);
        });

        Schema::table('order_passengers', function (Blueprint $table) {
            $table->dropColumn([
                'pickup_neighborhood', 'return_neighborhood', 
                'pickup_location_type', 'return_location_type', 
                'driver_arrival_time', 'work_start_time'
            ]);
        });
    }
};
