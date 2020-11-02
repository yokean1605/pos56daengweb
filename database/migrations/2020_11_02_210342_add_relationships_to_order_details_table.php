<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipsToOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            // order_id
            $table->integer('order_id')->unsigned()->change();
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            
            // product_id
            $table->integer('product_id')->unsigned()->change();
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // order details
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign('order_details_order_id_foreign');
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropIndex('order_details_order_id_foreign');
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->integer('order_id')->change();
        });

        // product_id
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign('order_details_product_id_foreign');
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropIndex('order_details_product_id_foreign');
        });
        Schema::table('order_details', function (Blueprint $table) {
            $table->integer('product_id')->change();
        });
    }
}
