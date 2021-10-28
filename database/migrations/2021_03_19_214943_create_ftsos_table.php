<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFtsosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftsos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('emblem');
            $table->string('logo');
            $table->longText('description');
            $table->longText('extended_description');
            $table->string('website');
            $table->string('website_url');
            $table->json('info');
            $table->json('socials');
            $table->string('admin_email');
            $table->boolean('verified');
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
        Schema::dropIfExists('ftsos');
    }
}