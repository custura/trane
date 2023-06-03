<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamProjectTemplateBindsPivotTable extends Migration
{
    public function up() : void
    {
        Schema::create('team_project_template_binds', function (Blueprint $table) {
            $table->foreignId('team_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreignId('project_id')->references('id')->on('team_projects')->cascadeOnDelete();
            $table->foreignId('template_id')->references('id')->on('team_project_templates')->cascadeOnDelete();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('team_project_template_binds');
    }
}
