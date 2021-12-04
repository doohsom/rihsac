<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashirTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashir_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('user_id');
            $table->string('amount');
            $table->string('location');
            $table->string('currency');
            $table->integer('payment_channel_id');
            $table->enum('transaction_type', ['LOAN, RECEIVER', 'PROVIDER', 'AGENT', 'OTHER'])->default('OTHER');
            $table->string('paymentReference')->nullable();
            $table->uuid('transaction_ref')->nullable();
            $table->enum('status', ['PENDING','CONFIRMED', 'REJECTED', 'FAILED', 'CANCELED', 'COMPLETED'])->default('PENDING');
            $table->longText('other_information');
            $table->string('payment_channel_status')->nullable();
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
        Schema::dropIfExists('cashir_transactions');
    }
}
