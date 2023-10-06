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
        Schema::table('data_pelanggars', function (Blueprint $table) {
            $table->bigInteger('no_agenda')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('derajat')->nullable();
            $table->integer('tipe_disposisi')->nullable();
            $table->string('limpah_unit')->nullable();
            $table->string('limpah_den')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_pelanggars', function (Blueprint $table) {
            $table->dropColumn('no_agenda');
            $table->dropColumn('klasifikasi');
            $table->dropColumn('derajat');
            $table->dropColumn('tipe_disposisi');
            $table->dropColumn('limpah_unit');
            $table->dropColumn('limpah_den');
        });
    }
};
