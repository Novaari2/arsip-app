<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRakDetailIdToBukuRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buku_registers', function (Blueprint $table) {
            $table->unsignedBigInteger('rak_gudang_detail_id')->after('rak_gudang_id')->nullable();
            $table->foreign('rak_gudang_detail_id')->references('id')->on('rak_gudang_details');
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
            $table->dropForeign(['rak_gudang_detail_id']);
            $table->dropColumn('rak_gudang_detail_id');
        });
    }
}
