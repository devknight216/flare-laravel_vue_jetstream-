<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureInviteCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_invite_codes', function (Blueprint $table) {
            $table->id();
            $table->string('feature');
            $table->unsignedBigInteger('user_id');
            $table->string('code');
            $table->integer('max_redemptions')->default(1);
            $table->integer('redemptions')->default(0);
            $table->dateTime('expiry');
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
        Schema::dropIfExists('feature_invite_codes');
    }
}