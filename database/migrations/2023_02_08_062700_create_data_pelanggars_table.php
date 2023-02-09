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
        Schema::create('data_pelanggars', function (Blueprint $table) {
            $table->id();
            $table->string('no_nota_dinas');
            $table->string('no_pengaduan');
            $table->string('pelapor')->nullable();
            $table->string('terlapor')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('nrp')->nullable();
            $table->string('wujud')->nullable();
            $table->string('polda')->nullable();
            $table->integer('status')->nullable();
            $table->date('tanggal')->nullable();

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
        Schema::dropIfExists('data_pelanggars');
    }
};