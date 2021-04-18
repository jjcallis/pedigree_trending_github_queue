<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoryStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repository_stars', function (Blueprint $table) {
            $table->unsignedBigInteger('repository_id')->primary();
            $table->integer('total')->nullable();
            $table->integer('daily')->nullable();
            $table->integer('monthly')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repository_stars');
    }
}
