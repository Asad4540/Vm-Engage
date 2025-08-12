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
            $table->json('single_adpreview')->nullable()->change();
            $table->json('single_size')->nullable()->change();
            $table->json('single_clicks')->nullable()->change();
            $table->json('single_impressions')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('single_adpreview')->nullable()->change();
            $table->string('single_size')->nullable()->change();
            $table->integer('single_clicks')->nullable()->change();
            $table->integer('single_impressions')->nullable()->change();
        });
    }
};
