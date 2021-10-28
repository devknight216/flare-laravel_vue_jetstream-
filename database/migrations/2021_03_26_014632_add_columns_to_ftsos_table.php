<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToFtsosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ftsos', function (Blueprint $table) {
            $table->longText('site_description')->after('verified')->nullable();
            $table->string('feature_video')->after('verified')->nullable();
            $table->string('meta_image')->after('verified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ftsos', function (Blueprint $table) {
            $table->dropColumn('site_description');
            $table->dropColumn('feature_video');
            $table->dropColumn('meta_image');
        });
    }
}