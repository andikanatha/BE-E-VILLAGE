<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentrembugs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('comment');
            $table->integer('id_user');
            $table->integer('id_post');
            $table->dateTime('commentdate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commentrembugs');
    }
};
