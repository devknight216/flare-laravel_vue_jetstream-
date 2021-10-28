<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatestWnatVotepowerColumnToNetworkStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('network_statistics', function (Blueprint $table) {
            $table->decimal('latest_wnat_votepower', 15, 2)->default(0)->after('latest_ftso_epoch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('network_statistics', function (Blueprint $table) {
            $table->dropColumn('latest_wnat_votepower');
        });
    }
}