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
        Schema::create('location_material_default', function (Blueprint $table) {
            $table->id();
            $table->string('material_code');
            $table->string('material_description');
            $table->string('uom');
            $table->integer('plant');
            $table->bigInteger('s_loc')->unsigned();
            $table->string('s_loc_description');
            $table->bigInteger('s_bin')->unsigned();
            $table->timestamps();

            $table->foreign('s_loc')->references('id')->on('master_storage_location');
            $table->foreign('s_bin')->references('id')->on('master_storage_bin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_material_default');
    }
};
