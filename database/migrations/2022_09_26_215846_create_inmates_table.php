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
        Schema::create('inmates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('national_id')->unique();
            $table->string('names');
            $table->string('father_names');
            $table->string('mother_names');
            $table->uuid('prison_id');
            $table->date('in_date');
            $table->string('inmate_code')->unique();
            $table->string('reason');
            $table->enum('status', \App\Models\Inmate::STATUS)->default(\App\Models\Inmate::ACTIVE);
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
        Schema::dropIfExists('inmates');
    }
};
