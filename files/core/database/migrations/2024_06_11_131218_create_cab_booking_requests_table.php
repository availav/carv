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
        Schema::create('cab_booking_requests', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('owner_id');
            $table->unsignedInteger('booking_id')->default(0);
            $table->unsignedInteger('user_id')->default(0);
            $table->integer('total_adult')->default(0);
            $table->unsignedInteger('total_child')->default(0);
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->decimal('total_amount', 28, 8)->default(0.00000000);
            $table->text('contact_info')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = request send, 1 = approved, 3 = cancelled');
            $table->timestamps(); // This 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cab_booking_requests');
    }
};
