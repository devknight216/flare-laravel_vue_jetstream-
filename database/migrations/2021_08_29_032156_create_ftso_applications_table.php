<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFtsoApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ftso_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->string('emblem');
            $table->string('logo');

            $table->longText('description');
            $table->longText('extended_description');
            $table->string('feature_video')->nullable();

            $table->string('website_url');
            $table->json('info');
            $table->json('socials');
            $table->string('admin_email');

            $table->longText('additional_comments')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('type', ['register', 'update'])->default('register');

            $table->foreignId('ftsos_id')->nullable();
            $table->foreignId('user_id');

            $table->longText('admin_notes')->nullable();

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
        Schema::dropIfExists('ftso_applications');
    }
}