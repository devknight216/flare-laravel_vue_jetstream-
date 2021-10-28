<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVotepowerAndFeeColumnToProviderPoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_pools', function (Blueprint $table) {
            $table->double('votepower')->after('network', 18, 12)->nullable();
            $table->integer('fee')->after('votepower')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_pools', function (Blueprint $table) {
            $table->dropColumn('votepower');
            $table->dropColumn('fee');
        });
    }
}