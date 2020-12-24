<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeProducts extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('stripe_products', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->string("name");
      $table->string("stripe_product_id");
      $table->double("amount");
      $table->integer("view")->comment("how much domains he can view");
      $table->integer("interval");
      $table->string("stripe_price_id");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('stripe_products');
  }
}
