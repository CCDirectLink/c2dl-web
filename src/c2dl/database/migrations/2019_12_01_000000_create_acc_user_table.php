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
        Schema::connection('acc')->create('acc_user', function (Blueprint $table) {
            $table->bigIncrements('user_id')->comment('Unique user id');
            $table->string('name', 64)->unique()->comment('Unique user name');
            $table->boolean('active')->default(false)
                ->comment('True if user is usable/active - False user not exist (anymore)');
            $table->dateTime('validate_at')->nullable()
                ->comment('Date if user validated (usable) - null unvalidated');
            $table->rememberToken();
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
        Schema::connection('acc')->dropIfExists('acc_user');
    }
}
