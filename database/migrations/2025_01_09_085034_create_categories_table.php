<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->integer('is_featured')->default(0);
            $table->integer('status')->default(1);
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->decimal('discount', 5, 2)->default(0)->nullable();
            $table->integer('is_display_slider')->default(0);
            $table->string('slider_image')->nullable();
            $table->integer('is_display_home')->default(0)->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories');
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
