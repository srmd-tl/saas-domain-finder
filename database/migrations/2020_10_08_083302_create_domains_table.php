<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("region")->comment("Region of the domain (us,canada or uk)");
            $table->dateTime("create_date");
            $table->dateTime("expiry_date");
            $table->boolean("is_present")->comment("If the site exists on the domain");
            $table->string("company_name")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("email")->nullable();
            $table->string("web_address")->nullable();
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("zip_code")->nullable();
            $table->text("title")->nullable();
            $table->text("description")->nullable();
            $table->string("facebook")->nullable()->comment("Facebook link");
            $table->string("twitter")->nullable()->comment("Twitter link");
            $table->string("instagram")->nullable()->comment("Instagram link");
            $table->string("linkedin")->nullable()->comment("LinkedIn link");
            $table->string("youtube")->nullable()->comment("Youtube link");
            $table->string("gmb")->nullable()->comment("Google My Business Page");
            $table->string("facebook_pixel")->nullable();
            $table->string("google_ads_pixel")->nullable();
            $table->string("name_servers")->nullable();
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
        Schema::dropIfExists('domains');
    }
}
