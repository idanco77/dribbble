<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignTable extends Migration
{
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('image');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_live')->default(false);
            $table->boolean('upload_successful')->default(false);
            $table->enum('disk', ['public', 'disk'])->default('public');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('design');
    }
}
