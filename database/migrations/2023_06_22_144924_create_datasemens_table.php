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
        Schema::create('datasemens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kaden');
            $table->string('pangkat_kaden');
            $table->string('nrp_kaden');
            $table->string('jabatan_kaden');
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
        Schema::dropIfExists('datasemens');
    }
};
