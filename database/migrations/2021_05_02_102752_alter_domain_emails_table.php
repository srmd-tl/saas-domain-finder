<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDomainEmailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('domain_emails', function (Blueprint $table) {
      $table->string('register_date')->nullable();
      $table->string('server')->nullable();
      $table->string('owner_name')->nullable();
      $table->string('other_name')->nullable();
      $table->string('address')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('zip')->nullable();
      $table->string('country')->nullable();
      $table->string('title')->nullable();
      $table->string('description')->nullable();



    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    //
  }
}
