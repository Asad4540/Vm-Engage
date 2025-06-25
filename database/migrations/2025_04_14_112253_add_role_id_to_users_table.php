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
        Schema::table('users', function (Blueprint $table) {
            // Add the column first, if it doesn't exist already
            $table->unsignedBigInteger('role_id')->nullable(); // or ->constrained() for shorthand

            // Add the foreign key constraint
            $table->foreign('role_id', 'fk_users_role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('fk_users_role_id');
            $table->dropColumn('role_id'); // optional: only if you want to remove the column too
        });
    }


};
