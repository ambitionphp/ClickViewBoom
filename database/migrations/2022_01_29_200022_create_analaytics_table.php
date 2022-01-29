<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalayticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analaytics', function (Blueprint $table) {
            $table->date('date')->primary();
            $table->unsignedInteger('api')->default(0);
            $table->unsignedInteger('web')->default(0);
            $table->unsignedInteger('total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analaytics');
    }
}
