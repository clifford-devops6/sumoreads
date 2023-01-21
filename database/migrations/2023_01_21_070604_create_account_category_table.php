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
        Schema::create('account_category', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('account_id')->unsigned()->index();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')
                ->on('accounts')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')
                ->on('categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_category');
    }
};
