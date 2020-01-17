<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('main')->create('main_news', function (Blueprint $table) {
            $table->unsignedBigInteger('news_id')->comment('Unique news id');
            $table->unsignedBigInteger('page_number')->default(1)->comment('Page number');
            $table->string('lang', 8)->default('en')->comment('News language');
            $table->primary(['news_id', 'page_number', 'lang']);
            // not foreign (seperate database)
            $table->unsignedBigInteger('author_id')
                ->comment('Author id (acc.acc_user/user_id)');
            $table->string('title', 64)->nullable()->comment('News title');
            $table->longText('content')->comment('News content');
            $table->string('preview_image')->comment('Preview image path')->nullable();
            $table->string('preview_content')
                ->comment('Preview content (shorted content if null)')->nullable();
            $table->boolean('active')->default(false)
                ->comment('True if news is active - False user not exist (anymore)');
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
        Schema::connection('main')->dropIfExists('main_news');
    }
}
