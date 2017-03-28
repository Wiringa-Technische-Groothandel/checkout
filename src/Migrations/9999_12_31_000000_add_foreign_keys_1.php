<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::table('quote_items', function (Blueprint $table) {
            $table->foreign('quote_id')->references('id')->on('quotes');
            $table->foreign('product_id')->references('id')->on('products');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        Schema::table('quote_items', function (Blueprint $table) {
            $table->dropForeign(['quote_id', 'product_id']);
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });
    }
}
