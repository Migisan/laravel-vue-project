<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('article_id')->unsigned()->comment('記事ID');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->bigInteger('user_id')->unsigned()->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('comment')->comment('コメント');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
