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
        Schema::create('tech_properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->timestamps();
        });

        DB::table('tech_properties')->insert([
            ['name' => 'IT Tech', 'url' => 'https://ittech-news.com/'],
            ['name' => 'CXO Insiders', 'url' => 'https://cxoinsiders.com/'],
            ['name' => 'Client Papers', 'url' => 'https://clientpapers.com/'],
            ['name' => 'Rev Tech', 'url' => 'https://revtech-news.com/'],
            ['name' => 'Fin Tech', 'url' => 'https://financetech-news.com/'],
            ['name' => 'Mar Tech', 'url' => 'https://martech-news.com/'],
            ['name' => 'HR Tech', 'url' => 'https://hrtech-news.com/'],
            ['name' => 'Soc News', 'url' => 'https://soc-news.com/'],

        ]);
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tech_properties');
    }
};
