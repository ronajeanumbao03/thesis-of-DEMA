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

        Schema::create('head_treasurers', function (Blueprint $table) {
            $table->id('head_treasurer_id');
            $table->string('treasurer_name');
            $table->unsignedBigInteger('section_assigned')->unique(); // 1 head per section
            $table->foreign('section_assigned')->references('section_id')->on('sections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('head_treasurers');
    }
};
