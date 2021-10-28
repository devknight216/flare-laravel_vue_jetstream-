<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFtsoRewardEpochsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftso_reward_epochs', function (Blueprint $table) {
            $table->id();
            $table->integer('epoch_id')->unique();
            $table->decimal('wnat_votepower', 15, 2);
            $table->integer('votepower_block');
            $table->integer('start_block');
            $table->integer('start_time');
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
        Schema::dropIfExists('ftso_reward_epochs');
    }
}
