<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNamaPemohonToBukuRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buku_registers', function (Blueprint $table) {
            $table->string('nama_pemohon')->after('nama_entitas_pemohon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buku_registers', function (Blueprint $table) {
            $table->dropColumn('nama_pemohon');
        });
    }
}
