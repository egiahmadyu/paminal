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
            $table->dropColumn('no_agenda');
            $table->dropColumn('klasifikasi');
            $table->dropColumn('derajat');
            $table->dropColumn('tipe_disposisi');
            $table->dropColumn('limpah_unit');
            $table->dropColumn('limpah_den');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
