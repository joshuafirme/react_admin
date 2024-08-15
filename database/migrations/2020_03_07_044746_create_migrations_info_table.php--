<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigrationsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('migrations_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0)->nullable();
            $table->string('complete_name')->nullable();
            $table->dateTime('date_of_arrival_abroad');
            $table->string('contact_person_ph')->nullable();
            $table->string('contact_number_ph')->nullable();
            $table->text('pra')->nullable();
            $table->string('fra')->nullable();
            $table->string('employer')->nullable();
            $table->text('attachment')->nullable(); 
            $table->integer('migration_status')->default(0)->nullable(); 
            $table->integer('status')->default(0)->nullable();
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
        Schema::dropIfExists('migrations_info');
    }
}
