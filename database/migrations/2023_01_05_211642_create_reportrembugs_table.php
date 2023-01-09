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
        Schema::create('reportrembugs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('description');
            $table->dateTime('report_date');
            $table->integer('id_user');
            $table->integer('id_user_posts');
            $table->integer('id_post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportrembugs');
    }
};
