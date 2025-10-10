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
    Schema::table('users', function (Blueprint $table) {
        $table->string('employee_id')->unique()->after('id');
        $table->string('first_name')->after('employee_id');
        $table->string('middle_name')->nullable()->after('first_name');
        $table->string('last_name')->after('middle_name');
        $table->string('address')->nullable()->after('email');
        $table->enum('role', ['admin', 'head', 'user'])->default('user')->after('address');
        $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
        $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('status');
        $table->date('birthdate')->nullable()->after('gender');
        $table->string('username')->unique()->after('birthdate');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'employee_id', 'first_name', 'middle_name', 'last_name',
            'address', 'role', 'status', 'gender', 'birthdate', 'username'
        ]);
    });
}

};
