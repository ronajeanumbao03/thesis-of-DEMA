<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('departments', 'name')) {
                $table->string('name');
            }

            if (!Schema::hasColumn('departments', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['name', 'description']);
        });
    }
};
