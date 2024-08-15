<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0)->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('subcategory_id')->default(0)->nullable();
            $table->string('transaction_type')->nullable();
            $table->integer('qty_assign')->nullable();
            $table->integer('qty_dropped')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->dateTime('date_registered');
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
        Schema::dropIfExists('table_logs');
    }
}
