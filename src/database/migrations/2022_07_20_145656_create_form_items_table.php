<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->references('id')->on('forms');
            $table->json('param_id')->nullable();
            $table->bigInteger('parent_id')->default(0);
            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('form_images');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('uuid');
            $table->string('title');
            $table->enum('type', ['page', 'question', 'section']);
            $table->boolean('repeat')->default(false);
            $table->tinyInteger('weight')->default(0);
            $table->boolean('required')->default(false);
            $table->boolean('negative')->default(false);
            $table->boolean('notes_allowed')->default(false);
            $table->boolean('photos_allowed')->default(false);
            $table->boolean('issues_allowed')->default(false);
            $table->boolean('responded')->default(false);
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
        Schema::dropIfExists('form_items');
    }
};
