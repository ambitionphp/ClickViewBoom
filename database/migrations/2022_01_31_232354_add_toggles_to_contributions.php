<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTogglesToContributions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->unsignedInteger('amount')->after('stripe_token');
            $table->unsignedTinyInteger('coffee')->default(0)->after('stripe_token');
            $table->unsignedTinyInteger('hosting')->default(0)->after('stripe_token');
            $table->unsignedTinyInteger('domain')->default(0)->after('stripe_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            //
        });
    }
}
