<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoryOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repository_owner', function (Blueprint $table) {
            $table->unsignedBigInteger('repository_id');
            $table->string('owner_name');

            $table->foreign('repository_id')->references('id')->on('repositories');
            $table->foreign('owner_name')->references('name')->on('owners');

            $table->primary(['repository_id', 'owner_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repository_owner');
    }
}
