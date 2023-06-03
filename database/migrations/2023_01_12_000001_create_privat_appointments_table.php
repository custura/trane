<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivatAppointmentsTable extends Migration
{
    public function up() : void
    {
        Schema::create('privat_appointments', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('start_time');
            $table->string('end_time')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('privat_appointments');
    }
}
