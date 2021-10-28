<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_submissions', function (Blueprint $table) {
            $table->id();
            $table->integer('epoch_id');
            $table->string('token');
            $table->string('token_address');
            $table->string('provider_uid');
            $table->string('provider_address');
            $table->bigInteger('submission');
            $table->string('nonce')->unique();
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
        Schema::dropIfExists('provider_submissions');
    }
}