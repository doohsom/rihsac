<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *id
     * @return void
     */
    public function up()
    {
        Schema::create('employment_information', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('user_id');
            $table->integer('employment_status');
            $table->integer('number_of_dependents');
            $table->string('monthly_income');
            $table->string('monthly_savings');
            $table->string('monthly_expense');
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
        Schema::dropIfExists('employment_information');
    }
}
