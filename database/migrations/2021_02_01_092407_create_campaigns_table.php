<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('campaigns', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->enum("status", ["NOT CONTACTED", "CONTACTED", "WON LEAD", "NO WEBSITE"]);
      $table->foreignId("domain_id");
      $table->longText("notes");

      //Foreign Keys
      $table->foreign("domain_id")->references("id")->on("domains")->onDelete("cascade");

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('campaigns');
  }
}
