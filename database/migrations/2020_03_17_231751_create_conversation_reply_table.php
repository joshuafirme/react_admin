<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('reply')->nullable();
            $table->integer('user_id_fk');
            $table->string('ip')->default()->nullable();
            $table->integer('c_id_fk');
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
        Schema::dropIfExists('conversation_reply');
    }
}
