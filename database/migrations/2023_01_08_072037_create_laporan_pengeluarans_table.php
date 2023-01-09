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
        Schema::create('laporan_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('nominal');
            $table->dateTime('date');
            $table->integer('id_user');
            $table->string('description');
            $table->string('keperluan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_pengeluarans');
    }
};
