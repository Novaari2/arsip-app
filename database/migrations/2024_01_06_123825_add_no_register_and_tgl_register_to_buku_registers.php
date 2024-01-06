<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoRegisterAndTglRegisterToBukuRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buku_registers', function (Blueprint $table) {
            $table->string('no_register')->after('rak_gudang_id');
            $table->timestamp('tgl_register')->after('no_register')->nullable();
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
            $table->dropColumn('no_register');
            $table->dropColumn('tgl_register');
        });
    }
}
