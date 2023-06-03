<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('team_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('description')->nullable();
            $table->time('pause_time_1')->nullable();
            $table->time('pause_time_2')->nullable();
            $table->time('pause_time_3')->nullable();
            $table->time('pause_time_4')->nullable();
            $table->time('work_time_1')->nullable();
            $table->time('work_time_2')->nullable();
            $table->time('work_time_3')->nullable();
            $table->time('work_time_4')->nullable();
            $table->string('tasks')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('team_projects');
    }
}
