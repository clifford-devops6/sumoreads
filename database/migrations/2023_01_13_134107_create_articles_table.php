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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('author')->nullable();
            $table->string('title', 300)->nullable();
            $table->string('slug', 300)->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('image_url')->nullable();
            $table->mediumText('article_url')->nullable();
            $table->text('content')->nullable();
            $table->string('published')->nullable();
            $table->bigInteger('status_id')->unsigned()->index();
            $table->bigInteger('source_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')
                ->on('statuses')->cascadeOnDelete();
            $table->foreign('source_id')->references('id')
                ->on('sources')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
