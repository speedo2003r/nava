<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /***
     * this table for original message sent and its info
     * not for show direct in queries
     * to get message use message_notifications table
     */

    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('type')->default('text'); // text - file
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
