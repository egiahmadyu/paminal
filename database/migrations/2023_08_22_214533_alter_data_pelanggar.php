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
            $table->string('no_nota_dinas')->nullable()->change();
            $table->string('no_pengaduan')->nullable()->change();
            $table->date('tanggal_nota_dinas')->nullable()->change();
            $table->string('ticket_id')->nullable();
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
