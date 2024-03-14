<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoSuratTugasPenjualToBukuRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buku_registers', function (Blueprint $table) {
            $table->string('no_surat_tugas_penjual')->after('nama_penjual')->nullable();
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
            $table->dropColumn('no_surat_tugas_penjual');
        });
    }
}
