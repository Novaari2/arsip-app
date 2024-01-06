<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglSuratTugasToBukuRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buku_registers', function (Blueprint $table) {
            $table->timestamp('tgl_surat_tugas')->after('st_lelang')->nullable();
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
            $table->dropColumn('tgl_surat_tugas');
        });
    }
}
