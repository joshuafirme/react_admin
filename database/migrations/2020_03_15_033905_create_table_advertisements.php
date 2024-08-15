<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdvertisements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organization_id')->default(0)->nullable();
            $table->string('ads_name')->nullable();
            $table->string('ads_description')->nullable();
            $table->string('ads_email')->nullable();
            $table->string('ads_type')->nullable();     
            $table->string('ads_url')->nullable(); 
            $table->string('ads_img')->nullable(); 
            $table->integer('ads_status')->default(0)->nullable();
            $table->integer('status')->default(1)->nullable();
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
        Schema::dropIfExists('advertisements');
    }
}
