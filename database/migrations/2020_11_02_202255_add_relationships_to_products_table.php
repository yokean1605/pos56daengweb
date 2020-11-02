<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Agar field category_id dapat dijadikan foreign key, maka perlu kita ubah menjadi unsigned().
         * Kita buat cascade saja agar ketika records pada table categories dihapus, 
         * maka child atau row yang menggunakan category_id tersebut pada table products akan ikut terhapus / update.
         */
        Schema::table('products', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->change();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_category_id_foreign');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_category_id_foreign');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('category_id')->change();
        });
    }
}
