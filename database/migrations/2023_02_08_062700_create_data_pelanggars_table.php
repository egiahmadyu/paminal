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
            $table->integer('umur')->nullable();
            $table->integer('jenis_kelamin')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->integer('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_identitas')->nullable();
            $table->integer('jenis_identitas')->nullable();
            // Terlapor
            $table->string('terlapor')->nullable();
            $table->string('kesatuan')->nullable();
            $table->string('tempat_kejadian')->nullable();
            $table->string('nrp')->nullable();
            $table->date('tanggal_kejadian')->nullable();
            $table->text('kronologi')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('nama_korban')->nullable();
            $table->integer('status_id')->nullable();

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