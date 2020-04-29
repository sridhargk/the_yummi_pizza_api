<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 60);
            $table->text('delivery_address');
            $table->text('locality');
            $table->bigInteger('customer_id', false, true);
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('total_quantity');
            $table->double('total_amount', 5, 2);
            $table->float('tax', 5, 2);
            $table->double('payable_amount', 5, 2);
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
        Schema::dropIfExists('orders');
    }
}
