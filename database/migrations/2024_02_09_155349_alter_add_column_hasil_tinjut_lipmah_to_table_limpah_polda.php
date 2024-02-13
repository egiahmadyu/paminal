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
        Schema::table('limpah_poldas', function (Blueprint $table) {
            $table->string('hasil_tinjut_limpah')->nullable()->after('isi_surat');
            $table->text('catatan')->nullable()->after('hasil_tinjut_limpah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('limpah_poldas', function (Blueprint $table) {
            //
        });
    }
};
