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
            // Change 'clicks' and 'impressions' columns to json and make them nullable
            $table->json('clicks')->change()->nullable();
            $table->json('impressions')->change()->nullable();

            // Add a new 'date' column (you can adjust the type as needed, e.g., date, datetime, etc.)
            $table->date('date')->nullable()->after('impressions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // Reverse the changes to 'clicks' and 'impressions' (assuming they were not json before)
            // Note: If they were a different type before (e.g., integer), you need to specify that type here
            $table->integer('clicks')->change()->nullable();
            $table->integer('impressions')->change()->nullable();

            // Drop the 'date' column
            $table->dropColumn('date');
        });
    }
};
