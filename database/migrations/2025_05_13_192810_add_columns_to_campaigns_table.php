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
            $table->unsignedBigInteger('tech_prop_id')->nullable();
            $table->foreign('tech_prop_id')
                ->references('id')
                ->on('tech_properties')
                ->onDelete('cascade');
            $table->string('url')->nullable();
            $table->decimal('delivered', 5, 2)->nullable();
            $table->decimal('remaining', 5, 2)->nullable();
            $table->string('pacing')->nullable();
            $table->string('clicks')->nullable();
            $table->string('impressions')->nullable();
            $table->decimal('mobile', 5, 2)->nullable();
            $table->decimal('desktop', 5, 2)->nullable();
            $table->string('country')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            //
        });
    }
};
