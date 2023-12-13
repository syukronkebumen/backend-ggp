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
        Schema::create('master_storage_bin', function (Blueprint $table) {
            $table->id();
            $table->string('s_bin');
            $table->bigInteger('s_loc')->unsigned();
            $table->string('s_loc_description');
            $table->integer('plant');
            $table->timestamps();

            $table->foreign('s_loc')->references('id')->on('master_storage_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_storage_bin');
    }
};
