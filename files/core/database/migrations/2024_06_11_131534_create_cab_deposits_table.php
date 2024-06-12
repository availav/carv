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
        Schema::create('cab_deposits', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('owner_id')->default(0);
            $table->integer('booking_id')->default(0);
            $table->unsignedInteger('pay_for_month')->default(0)->comment('Ex: owner pay for 12 months');
            $table->unsignedInteger('method_code')->default(0);
            $table->decimal('amount', 28, 8)->default(0.00000000);
            $table->string('method_currency', 40)->nullable();
            $table->decimal('charge', 28, 8)->default(0.00000000);
            $table->decimal('rate', 28, 8)->default(0.00000000);
            $table->decimal('final_amo', 28, 8)->default(0.00000000);
            $table->text('detail')->nullable();
            $table->string('btc_amo', 255)->nullable();
            $table->string('btc_wallet', 255)->nullable();
            $table->string('trx', 40)->nullable();
            $table->integer('payment_try')->default(0);
            $table->tinyInteger('status')->default(0)->comment('1=>success, 2=>pending, 3=>cancel');
            $table->tinyInteger('from_api')->default(0);
            $table->string('admin_feedback', 255)->nullable();
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
        Schema::dropIfExists('cab_deposits');
    }
};
