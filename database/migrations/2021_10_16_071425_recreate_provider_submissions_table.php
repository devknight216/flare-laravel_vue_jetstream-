<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateProviderSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('provider_submissions');

        Schema::create('provider_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_uid');
            $table->string('provider_address');
            $table->unsignedInteger('epoch_id');
            $table->string('symbol');
            $table->bigInteger('submission')->nullable();
            $table->integer('committed_at');
            $table->integer('revealed_at');
            $table->integer('commit_offset');
            $table->integer('reveal_offset');
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