<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotifiersToAgentNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_notes', function (Blueprint $table) {
            $table->string('notify_handler');
            $table->string('notify_spymaster');
            $table->string('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agents', function (Blueprint $table) {
             $table->string('notify_handler');
            $table->string('notify_spymaster');
            $table->string('category');
        });
    }
}
