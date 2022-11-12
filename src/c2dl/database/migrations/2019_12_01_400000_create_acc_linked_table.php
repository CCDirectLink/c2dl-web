<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccLinkedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('acc')->create('acc_linked', function (Blueprint $table) {
            $table->string('link_service', 16)->comment('Link service (e.g. discord)');
            $table->string('link_ident', 64)->comment('Unique link identifier');
            $table->primary(['link_service', 'link_ident']);
            $table->unsignedBigInteger('user_id')->comment('User reference');
            $table->foreign('user_id')->references('user_id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('label', 64)->nullable()->comment('User-Custom Link label');
            $table->dateTime('validate_at')->nullable()
                ->comment('Date if link validated (usable) - null unvalidated');
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
        Schema::connection('acc')->dropIfExists('acc_linked');
    }
}
