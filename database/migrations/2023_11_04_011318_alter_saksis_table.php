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
        Schema::table('saksis', function (Blueprint $table) {
            $table->renameColumn('name', 'nama');
            $table->string('jenis_kelamin')->nullable()->after('name');
            $table->text('alamat')->nullable()->after('jenis_kelamin');
            $table->string('no_telp')->nullable()->after('alamat');
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
