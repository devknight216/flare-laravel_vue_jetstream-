<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinalisedColumnToFtsoUserRewardStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ftso_user_reward_states', function (Blueprint $table) {
            $table->boolean('finalised')->after('claimable')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ftso_user_reward_states', function (Blueprint $table) {
            $table->dropColumn('finalised');
        });
    }
}