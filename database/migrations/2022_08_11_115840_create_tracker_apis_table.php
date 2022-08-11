<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_apis', function (Blueprint $table) {
            $table->id();
            $table->text('ip_adress');
            $table->text('locations');
            $table->text('OS');
            $table->text('device');
            $table->text('refferer');
            $table->text('url');
            $table->text('language');
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
        Schema::dropIfExists('tracker_apis');
    }
}
