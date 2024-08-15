<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('employee_no', 80)->nullable()->default(null);
            $table->string('transaction_type', 80)->nullable()->default(null);
            $table->string('qty_assigned', 80)->nullable()->default(null);
            $table->string('qty_dropped', 80)->nullable()->default(null);
            $table->string('firstname', 80)->nullable()->default(null);
             $table->string('middlename', 80)->nullable()->default(null);
             $table->string('lastname', 80)->nullable()->default(null);
             $table->string('phone_number', 80)->nullable()->default(null);
             $table->string('profile_photo', 250)->nullable()->default(null);
            $table->integer('role_id')->default(3)->nullable();
            $table->integer('agency_id')->default(0)->nullable();
            $table->integer('organization_id')->default(0)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
             $table->string('birthday', 80)->nullable()->default(null);
            $table->string('gender', 80)->nullable()->default(null);
            $table->integer('status')->default(1)->nullable();
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
