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
        Schema::create('meeting__tokens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('meeting_id');
            $table->longText('visitor_token')->nullable();
            $table->longText('inmate_token')->nullable();
            $table->string('visitor_code')->nullable();
            $table->string('inmate_code')->nullable();
            $table->longText('admin_token')->nullable();
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
        Schema::dropIfExists('meeting__tokens');
    }
};
