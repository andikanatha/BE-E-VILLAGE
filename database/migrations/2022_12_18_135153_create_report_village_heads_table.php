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
        Schema::create('report_village_heads', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->timestamps();
            $table->string('image')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('tempat_kejadian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_village_heads');
    }
};
