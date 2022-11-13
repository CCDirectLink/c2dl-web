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
        Schema::connection('acc')->rename('acc_user', 'users');
        Schema::connection('acc')->table('users', function (Blueprint $table) {
            $table->dropColumn('created_at', 'updated_at');

            $table->string('email')->unique()->comment('Unique user email');
            $table->string('password')->comment('User chosen password');
        });

        // Had to split this into another call to `table` due to "duplicate column" errors.
        Schema::connection('acc')->table('users', function (Blueprint $table) {
            $table->timestamps();
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
            $table->dropColumn('email', 'password', 'created_at', 'updated_at');
        });

        Schema::connection('acc')->table('users', function (Blueprint $table) {
            $table->dateTime('created_at')->useCurrent()->comment('Created');
            $table->dateTime('updated_at')->nullable()->comment('Updated, null if not');
        });

        Schema::connection('acc')->rename('users', 'acc_user');
    }
};
