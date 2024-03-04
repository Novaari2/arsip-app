<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreign('risalah_lelang_id')->references('id')->on('buku_registers');
            $table->string('no_lot_barang');
            $table->text('uraian_barang');
            $table->integer('uang_jaminan');
            $table->integer('nilai_limit');
            $table->string('nama_pembeli');
            $table->text('alamat_pembeli');
            $table->string('no_ktp');
            $table->integer('pokok_lelang');
            $table->string('bea_penjual');
            $table->string('bea_pembeli');
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
        Schema::dropIfExists('barangs');
    }
}
