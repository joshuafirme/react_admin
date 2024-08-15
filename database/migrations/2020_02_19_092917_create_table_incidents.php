<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIncidents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0)->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('subcategory_id')->default(0)->nullable();
            $table->string('incident_name')->nullable();
            $table->string('forwarded_to')->nullable();
            $table->integer('agency_id')->nullable();
            $table->text('location')->nullable();
            $table->string('incident_description')->nullable();
            $table->text('attachment')->nullable(); 
            $table->integer('incident_status')->default(0)->nullable(); 
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
        Schema::dropIfExists('table_incidents');
    }
}
