<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropColumn(['domain','hosting','coffee']);
        });
        Schema::table('contributions', function (Blueprint $table) {
            $table->unsignedInteger('coffee')->default(0)->after('stripe_token');
            $table->unsignedInteger('hosting')->default(0)->after('stripe_token');
            $table->unsignedInteger('domain')->default(0)->after('stripe_token');
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
