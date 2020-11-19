<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCartProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_item_id');
            $table->unsignedBigInteger('variant_id');
            $table->string('variant_type')->nullable();
            $table->timestamps();
            $table->foreign('cart_item_id')->references('id')->on('cart_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_product_variants', function (Blueprint $table) {
            $table->dropForeign(['cart_item_id']);
        });
        Schema::dropIfExists('cart_product_variants');
    }
}
