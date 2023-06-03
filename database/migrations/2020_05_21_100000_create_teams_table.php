<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('name');
            $table->boolean('personal_team');
            $table->string('group_key')->nullable();
            $table->string('description', 255)->nullable();
            $table->string('lang', 10)->default('en');
            $table->string('date_format', 20)->default('%Y-%m-%d');
            $table->string('time_format', 20)->default('%H:%M');
            $table->smallInteger('week_start')->default('0');
            $table->smallInteger('tracking_mode')->default('1');
            $table->smallInteger('project_required')->default('0');
            $table->smallInteger('record_type')->default('0');
            $table->string('plugins', 255)->nullable();
            $table->string('lock_spec', 255)->nullable();
            $table->smallInteger('workday_minutes')->default('480');
            $table->tinyInteger('custom_logo')->default('0');
            $table->text('config')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamp('expires_at');
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
