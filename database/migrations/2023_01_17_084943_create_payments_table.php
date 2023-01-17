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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('phone_number')->nullable();
            $table->text('email')->nullable();
            $table->text('amount');
            $table->string('currency');
            $table->string('reference');
            $table->text('description');
            $table->text('status')->nullable();
            $table->text('tracking_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->bigInteger('account_id')->index()->unsigned();
            $table->bigInteger('user_id')->index()->unsigned();
            $table->foreign('account_id')->references('id')
                ->on('accounts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
