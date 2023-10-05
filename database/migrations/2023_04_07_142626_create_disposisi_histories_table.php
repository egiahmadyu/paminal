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
        Schema::create('disposisi_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_pelanggar_id');
            $table->bigInteger('no_agenda')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('derajat')->nullable();
            $table->integer('tipe_disposisi')->nullable();
            $table->string('limpah_unit')->nullable();
            $table->string('limpah_den')->nullable();
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
        Schema::dropIfExists('disposisi_histories');
    }
};
