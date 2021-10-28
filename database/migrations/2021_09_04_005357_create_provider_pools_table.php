<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_pools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ftso_id');
            $table->string('name');
            $table->string('description');
            $table->string('address');
            $table->enum('network', ['coston', 'songbird', 'flare']);
            $table->boolean('approved')->default(0);
            $table->timestamps();

            $table->foreign('ftso_id')->references('id')->on('ftsos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_pools');
    }
}