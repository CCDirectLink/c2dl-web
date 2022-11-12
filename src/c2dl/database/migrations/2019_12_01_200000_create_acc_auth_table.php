<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('acc')->create('acc_auth', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->comment('User reference');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('auth_id')->default(0)->comment('Id for auth entry');
            $table->primary(['user_id', 'auth_id']);
            $table->string('label', 64)->nullable()->comment('User-Custom Auth label');
            $table->string('type', 32)->comment('Auth type');
            $table->longText('data')->comment('Auth data');
            $table->dateTime('validate_at')->nullable()
                ->comment('Date if auth validated (usable) - null unvalidated');
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
        Schema::connection('acc')->dropIfExists('acc_auth');
    }
}
