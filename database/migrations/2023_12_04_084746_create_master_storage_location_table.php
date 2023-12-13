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
        Schema::create('master_storage_location', function (Blueprint $table) {
            $table->id();
            $table->string('s_loc');
            $table->string('description');
            $table->integer('plant');
            $table->string('inbound');
            $table->string('otbound');
            $table->string('batch');
            $table->bigInteger('departement')->unsigned();
            $table->timestamps();

            $table->foreign('departement')->references('id')->on('master_departement');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_storage_location');
    }
};
