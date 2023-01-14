<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('type_id')->unsigned()->index();
            $table->bigInteger('status_id')->unsigned()->index();
            $table->string('name');
            $table->foreign('type_id')->references('id')
                ->on('types')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')
                ->on('statuses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
