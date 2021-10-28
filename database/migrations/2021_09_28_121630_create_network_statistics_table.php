<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworkStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('network_statistics', function (Blueprint $table) {
            $table->id();
            $table->enum('network', ['flare', 'songbird'])->default('flare');
            $table->decimal('circulating_supply', 15, 2)->default(0);
            $table->decimal('foundation_supply', 15, 2)->default(0);
            $table->decimal('inflation_authorised', 15, 2)->default(0);
            $table->decimal('inflatable_balance', 15, 2)->default(0);
            $table->decimal('ftso_rewards_total', 15, 2)->default(0);
            $table->decimal('ftso_rewards_claimed', 15, 2)->default(0);
            $table->decimal('ftso_rewards_expired', 15, 2)->default(0);
            $table->integer('latest_reward_epoch')->default(0);
            $table->decimal('latest_reward_epoch_votepower', 15, 2)->default(0);
            $table->integer('latest_reward_epoch_votepower_block')->default(0);
            $table->integer('latest_reward_epoch_start_block')->default(0);
            $table->integer('latest_reward_epoch_start')->default(0);
            $table->integer('latest_ftso_epoch')->default(0);
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
        Schema::dropIfExists('network_statistics');
    }
}