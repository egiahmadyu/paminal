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
        Schema::table('data_anggotas', function (Blueprint $table) {
            $table->string('nama')->change()->nullable();
            $table->string('pangkat')->change()->nullable();
            $table->string('nrp')->change()->nullable();
            $table->string('jabatan')->change()->nullable();
            $table->string('unit')->change()->nullable();
            $table->string('datasemen')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_anggotas', function (Blueprint $table) {
            //
        });
    }
};
