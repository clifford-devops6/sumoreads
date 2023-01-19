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
        Schema::create('group_source', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('source_id')->unsigned()->index();
            $table->bigInteger('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')
                ->on('groups')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_source');
    }
};
