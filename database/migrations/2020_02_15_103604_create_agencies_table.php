<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organization_id')->default(0)->nullable();
            $table->string('agency_name')->nullable();
            $table->string('agency_description')->nullable();
            $table->string('agency_email')->nullable();
            $table->string('agency_type')->nullable();
            $table->integer('agency_status')->default(0)->nullable();
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
        Schema::dropIfExists('agencies');
    }
}
