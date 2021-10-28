<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFtsoUserRewardStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftso_user_reward_states', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->decimal('votepower', 15, 2)->default(0);
            $table->integer('epoch_id');
            $table->decimal('epoch_rewards', 15, 2);
            $table->decimal('day_rewards', 15, 2);
            $table->unsignedBigInteger('provider_id_1')->nullable();
            $table->integer('provider_percentage_1')->nullable();
            $table->boolean('provider_claimed_1')->nullable();
            $table->unsignedBigInteger('provider_id_2')->nullable();
            $table->integer('provider_percentage_2')->nullable();
            $table->boolean('provider_claimed_2')->nullable();
            $table->boolean('claimable')->nullable();
            $table->timestamps();
            $table->index(['address', 'epoch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ftso_user_reward_states');
    }
}