<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku_registers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pejabat_lelang_id');
            $table->unsignedBigInteger('kategori_pemohon_id');
            $table->unsignedBigInteger('jenis_lelang_id');
            $table->unsignedBigInteger('rak_gudang_id');
            $table->string('no_tiket_permohonan');
            $table->string('nama_entitas_pemohon');
            $table->string('no_permohonan');
            $table->timestamp('tgl_permohonan')->nullable();
            $table->string('nama_debitur');
            $table->string('no_hpkb');
            $table->timestamp('tgl_hpkb')->nullable();
            $table->string('no_penetapan');
            $table->timestamp('tgl_penetapan')->nullable();
            $table->string('tempat_lelang');
            $table->string('no_risalah');
            $table->timestamp('tgl_lelang')->nullable();
            $table->string('no_lot_barang');
            $table->string('st_lelang');
            $table->string('nama_penjual');
            $table->string('st_penjual');
            $table->string('jenis_penawaran');
            $table->text('uraian_barang');
            $table->integer('uang_jaminan');
            $table->integer('nilai_limit');
            $table->string('nama_pembeli');
            $table->text('alamat_pembeli');
            $table->string('no_ktp');
            $table->integer('pokok_lelang');
            $table->integer('bea_penjual');
            $table->integer('bea_pembeli');
            $table->tinyInteger('status_lelang')->comment('1 = Laku, 2 = TAP, 3 = Ditahan, 4 = Batal, 5 = Batal Krn Pelunasan');
            $table->softDeletes();
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
        Schema::dropIfExists('buku_registers');
    }
}
