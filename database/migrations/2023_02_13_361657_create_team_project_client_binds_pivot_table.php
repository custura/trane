<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamProjectClientBindsPivotTable extends Migration
{
    public function up() : void
    {
        Schema::create('team_project_client_binds', function (Blueprint $table) {
            $table->foreignId('team_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreignId('project_id')->references('id')->on('team_projects')->cascadeOnDelete();
            $table->foreignId('client_id')->references('id')->on('team_clients')->cascadeOnDelete();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('team_project_client_binds');
    }
}
