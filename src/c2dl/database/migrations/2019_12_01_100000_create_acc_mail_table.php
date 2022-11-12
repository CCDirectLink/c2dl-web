<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('acc')->create('acc_mail', function (Blueprint $table) {
            $table->string('mail', 64)->primary()->comment('Unique Mail Address');
            $table->unsignedBigInteger('user_id')->comment('User reference');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('label', 64)->nullable()->comment('User-Custom Mail label');
            $table->boolean('prim_addr')->default(true)->comment('True if primary');
            $table->boolean('notify_addr')->default(true)->comment('True if notify address');
            $table->boolean('sec_addr')->default(true)->comment('True if security address');
            $table->dateTime('validate_at')->nullable()
                ->comment('Date if email validated (usable) - null unvalidated');
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
        Schema::connection('acc')->dropIfExists('acc_mail');
    }
}
