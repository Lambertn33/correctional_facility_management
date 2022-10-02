<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('names');
            $table->bigInteger('telephone');
            $table->bigInteger('national_id');
            $table->uuid('inmate_id');
            $table->uuid('tariff_id');
            $table->uuid('prison_id');
            $table->date('date');
            $table->enum('status', \App\Models\Appointment::STATUS)->default(\App\Models\Appointment::PENDING);
            $table->timestamp('from')->nullable();
            $table->timestamp('to')->nullable();
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
        Schema::dropIfExists('appointments');
    }
};
