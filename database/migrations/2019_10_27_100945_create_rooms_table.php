<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{

    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('private')->default(0); // not used yet
            $table->string('type')->default('order'); // order/support
            $table->foreignId('order_id')->nullable(); // order/support
            $table->integer('user_id'); // creater
            $table->integer('other_user_id')->nullable(); // partner in private room
            $table->integer('last_message_id')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }


    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
