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
        Schema::table('master_storage_location', function (Blueprint $table) {
            $table->boolean('inbound')->change();
            $table->boolean('batch')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_storage_location', function (Blueprint $table) {
            $table->string('inbound')->change();
            $table->string('batch')->change();
        });
    }
};
