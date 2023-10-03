<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handlers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('gsf_forum_name')->nullable();
            $table->string('skype_name')->nullable();
            $table->string('discord_name')->nullable();
            $table->string('timezone')->nullable();
            $table->string('status', 20)->index();
            $table->string('notes')->nullable();;
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
        Schema::dropIfExists('handlers');
    }
}
