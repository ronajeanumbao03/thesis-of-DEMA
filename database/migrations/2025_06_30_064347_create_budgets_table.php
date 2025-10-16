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
        Schema::table('budgets', function (Blueprint $table) {
            if (!Schema::hasColumn('budgets', 'total_amount')) {
                $table->decimal('total_amount', 10, 2);
            }
            if (!Schema::hasColumn('budgets', 'spent_amount')) {
                $table->decimal('spent_amount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('budgets', 'remaining_amount')) {
                $table->decimal('remaining_amount', 10, 2);
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
