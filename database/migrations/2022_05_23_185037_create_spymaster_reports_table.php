<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpymasterReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // schema id: start_date: end_date: week_number: year: report_type: status: active_agents: active_handlers: active_groups: report_data(json): created_at: updated_at: 
        Schema::create('spymaster_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('start_date');
            $table->string('end_date');
            $table->integer('week_number');
            $table->string('month');
            $table->integer('year');
            $table->string('report_type');
            $table->string('status');
            $table->integer('active_agents');
            $table->integer('active_handlers');
            $table->integer('active_groups');
            $table->json('report_data');
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
        Schema::dropIfExists('spymaster_reports');
    }
}
