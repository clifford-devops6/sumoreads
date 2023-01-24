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
        Schema::create('readlists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('article_id')->unsigned()->index();
            $table->integer('read_status')->default(0);
            $table->foreign('user_id')->references('id')->on('users')
            ->cascadeOnDelete();
            $table->foreign('article_id')->references('id')->on('articles')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('readlists');
    }
};
