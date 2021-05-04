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
      $table->boolean("is_present")->default(0);
      $table->string('register_date')->nullable();
      $table->string('server')->nullable();
      $table->string('owner_name')->nullable();
      $table->string('other_name')->nullable();
      $table->string('address')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('zip')->nullable();
      $table->string('country')->nullable();
      $table->text('title')->nullable();
      $table->text('description')->nullable();



    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table("domain_emails", function (Blueprint $table) {
      $table->dropColumn("is_present");
      $table->dropColumn('register_date');
      $table->dropColumn('server');
      $table->dropColumn('owner_name');
      $table->dropColumn('other_name');
      $table->dropColumn('address');
      $table->dropColumn('city');
      $table->dropColumn('state');
      $table->dropColumn('zip');
      $table->dropColumn('country');
      $table->dropColumn('title');
      $table->dropColumn('description');
    });
  }
}
