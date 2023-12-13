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
        Schema::create('master_material', function (Blueprint $table) {
            $table->increments('id');
            $table->string('material_code')->unique();
            $table->string('material_description');
            $table->bigInteger('uom')->unsigned();
            $table->string('batch');
            $table->integer('plant');
            $table->timestamps();

            $table->foreign('uom')->references('id')->on('master_uom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_material');
    }
};
