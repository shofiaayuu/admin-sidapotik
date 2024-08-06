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
        Schema::create('daftar_info_peluangs', function (Blueprint $table) {
            $table->id();
            $table->string('tahun');
            $table->string('prospek_bisnis');
            $table->string('nama');
            $table->string('biaya_investasi');
            $table->string('biaya_oprasional');
            $table->string('keterangan');
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
        Schema::dropIfExists('daftar_info_peluangs');
    }
};
