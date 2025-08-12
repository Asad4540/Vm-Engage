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
            $table->string('single_adpreview')->nullable()->after('campaign_type'); // path to image
            $table->string('single_size')->nullable()->after('single_adpreview');
            $table->integer('single_clicks')->nullable()->after('single_size');
            $table->integer('single_impressions')->nullable()->after('single_clicks');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn([
                'single_adpreview',
                'single_size',
                'single_clicks',
                'single_impressions',
            ]);
        });
    }
};
