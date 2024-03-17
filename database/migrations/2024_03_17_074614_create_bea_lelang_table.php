<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeaLelangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bea_lelangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('tipe', ['BTB', 'BB']);
            $table->integer('bea_penjual');
            $table->integer('bea_pembeli');
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
        Schema::dropIfExists('bea_lelang');
    }
}
