<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHandlerActionsToAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->string('confirm_relay');
            $table->string('recieved_training_manual');
            $table->string('completed_questionaire');
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
         $table->string('confirm_relay');
         $table->string('recieved_training_manual');
         $table->string('completed_questionaire');
     });
    }
}
