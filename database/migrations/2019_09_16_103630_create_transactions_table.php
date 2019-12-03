<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //user making the payment/transaction
            $table->integer('qrcode_id');
            $table->float('amount', 10, 4);
            $table->string('payment_method');   //PayPal, Stripe, Paystack etc.
            $table->integer('qrcode_owner_id')->nullble();
            $table->longText('message')->nullable();  //Transaction feedback string from payment processor
            $table->string('status')->default('Initiated'); //Initiated, Completed, and Payment Fail.
            $table->softDeletes();
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
        Schema::dropIfExists('transactions');
    }
}
