<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccAuthGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('acc')->create('acc_auth_group', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->comment('User reference');
            $table->unsignedBigInteger('auth_id')->comment('Auth reference');
            $table->foreign(['user_id', 'auth_id'])->references(['user_id', 'auth_id'])->on('acc_auth')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('auth_group_id')->comment('Auth Group id');
            $table->primary(['user_id', 'auth_id']);
            $table->dateTime('created_at')->useCurrent()->comment('Created');
            $table->dateTime('updated_at')->nullable()->comment('Updated, null if not');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('acc')->dropIfExists('acc_auth_group');
    }
}
