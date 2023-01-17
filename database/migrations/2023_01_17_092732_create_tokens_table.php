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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('token');
            $table->dateTime('expiry');
            $table->integer('slots');
            $table->bigInteger('account_id')->unsigned()->index();
            $table->bigInteger('payment_id')->unsigned()->index();
            $table->bigInteger('balance_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')
                ->on('accounts')->cascadeOnDelete();
            $table->foreign('payment_id')->references('id')
                ->on('payments')->cascadeOnDelete();
            $table->foreign('balance_id')->references('id')
                ->on('balances')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tokens');
    }
};
