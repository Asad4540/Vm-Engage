<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            Schema::table('campaigns', function (Blueprint $table) {
                // Change 'date' column to JSON or TEXT (depending on your choice)
                $table->json('date')->nullable()->change();  // Or use ->text() if you're not using JSON
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            Schema::table('campaigns', function (Blueprint $table) {
                // Rollback to original type — assuming it was DATE
                $table->date('date')->nullable()->change();
            });
        });
    }
};
