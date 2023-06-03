<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamProjectUserBindsPivotTable extends Migration
{
    public function up() : void
    {
        Schema::create('team_project_user_binds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('team_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreignId('project_id')->references('id')->on('team_projects')->cascadeOnDelete();
            $table->float('rate', 6, 2)->default("0.00");
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('team_project_user_binds');
    }
}
