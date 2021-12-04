<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->uuid('uuid');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('username')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('state_id')->nullable();
            $table->string('cashir_id')->unique()->nullable();
            $table->boolean('email_verified')->default(false);
            $table->boolean('phone_number_verified')->default(false);
            $table->enum('role',['USER', 'ADMIN', 'SUPERADMIN']);
            $table->string('transaction_pin')->nullable();
            $table->string('avatar')->nullable();
            $table->string('onboarding_stage');
            $table->enum('status', ['enabled', 'disabled'])->default('disabled');
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
}
