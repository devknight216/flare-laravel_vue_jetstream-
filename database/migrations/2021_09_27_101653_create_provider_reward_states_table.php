<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderRewardStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_reward_states', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provider_id');
            $table->string('provider_address');
            $table->double('provider_reward_state', 14, 4);
            $table->double('provider_votepower', 14, 4);
            $table->string('provider_fee');
            $table->integer('reward_epoch');
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
        Schema::dropIfExists('provider_reward_states');
    }
}