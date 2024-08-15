<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('log_id')->nullable();
            $table->string('drop_off_points')->nullable();
            $table->string('coord_x')->nullable();
            $table->string('coord_y')->nullable(); 
            $table->string('transaction_type')->nullable();
            $table->string('qty_dropped')->nullable();
            $table->string('qty_remainings')->nullable();
            $table->string('remarks')->nullable();
            $table->text('signature')->nullable();
            $table->integer('status')->default(1)->nullable();
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
        Schema::dropIfExists('logdetails');
    }
}
