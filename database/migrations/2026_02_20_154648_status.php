<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * TO RUN THE MIGRATION, RUN THE COMMAND: php artisan migrate
     */
    public function up(): void
    {
        Schema::table('collected_tickets', function (Blueprint $table) {
                $table->string('status')->default('OPEN');
        });
    }

    /**
     * Reverse the migrations.
     * TO ROLLBACK THE MIGRATION, RUN THE COMMAND: php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::table('collected_tickets', function (Blueprint $table) {
                $table->dropColumn('status');
        });
    }
};
