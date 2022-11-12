<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('acc')->create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name', 64)->unique()->comment('Unique user name');
            $table->string('email')->unique();
            $table->boolean('active')->default(false)
                ->comment('True if user is usable/active - False user not exist (anymore)');
            $table->dateTime('validate_at')->nullable()
                ->comment('Date if user validated (usable) - null unvalidated');
            $table->string('password');
            $table->rememberToken();
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
        Schema::connection('acc')->dropIfExists('users');
    }
}
