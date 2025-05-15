<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('prodcut_id');
            $table->string('featured_image')->nullable();
            $table->dateTime('publish_date');
            $table->integer('status');
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('article_categories')->onDelete('cascade');
            $table->foreign('product_category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('prodcut_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
