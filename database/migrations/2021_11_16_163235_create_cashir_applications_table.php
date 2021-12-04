<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashirApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashir_applications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('user_id');
            $table->string('amount');
            $table->string('tenor');
            $table->enum('status', ['PENDING', 'REJECTED', 'APPROVED', 'DISBURSED']);
            $table->longText('other_information');
            $table->longText('loan_history');
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
        Schema::dropIfExists('cashir_applications');
    }
}
