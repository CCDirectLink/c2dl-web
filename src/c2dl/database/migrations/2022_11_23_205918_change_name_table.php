<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('acc')->table('users', function (Blueprint $table) {
            $table->dropColumn('name');

            $table->string('username', 64)->unique()->comment('Unique username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('acc')->table('users', function (Blueprint $table) {
            $table->dropColumn('username');

            $table->string('name', 64)->unique()->comment('Unique user name');
        });
    }
};
