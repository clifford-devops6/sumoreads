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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('account_id')->index();
            $table->float('amount',8,2);
            $table->string('status')->comment('pending/paid');
            $table->text('description');
            $table->string('balance_id')->unique();
            $table->integer('slots');
            $table->date('expires');
            $table->string('balance_type')->comment('Full/Additional');
            $table->foreign('account_id')->references('id')->on('accounts')
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
        Schema::dropIfExists('balances');
    }
};
