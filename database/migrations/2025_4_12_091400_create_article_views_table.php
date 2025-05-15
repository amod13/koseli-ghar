<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleViewsTable extends Migration
{
    public function up()
    {
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->integer('views')->default(0);
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_views');
    }
}