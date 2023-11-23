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
        Schema::create('undangan_klarifikasi_histori', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_pelanggar_id');
            $table->string('no_surat_undangan');
            $table->date('tgl_klarifikasi');
            $table->time('waktu_klarifikasi');
            $table->integer('jenis_undangan');
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
        Schema::dropIfExists('undangan_klarifikasi_histories');
    }
};
