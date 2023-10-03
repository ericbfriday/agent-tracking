<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactNoteNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_note_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('note_id');
            $table->unsignedInteger('to');
            $table->unsignedInteger('from');
            $table->unsignedInteger('acknowledged');
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
        Schema::drop('contact_note_notifications');
    }
}
