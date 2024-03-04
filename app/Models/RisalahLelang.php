<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RisalahLelang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'buku_registers';
    // protected $fillable = [
    //     'pejabat_lelang_id',
    //     'kategori_pemohon_id',
    //     'jenis_lelang_id',
    //     'rak_gudang_id',
    //     'no_register',
    //     'tgl_register',
    //     'no_tiket_permohonan',
    //     'nama_entitas_pemohon',
    //     'nama_pemohon',
    //     'no_permohonan',
    //     'tgl_permohonan',
    //     'nama_debitur',
    //     'no_hpkb',
    //     'tgl_hpkb',
    //     'no_penetapan',
    //     'tgl_penetapan',
    //     'tempat_lelang',
    //     'no_risalah',
    //     'tgl_lelang',
    //     'no_lot_barang',
    //     'st_lelang',
    //     'tgl_surat_tugas',
    //     'nama_penjual',
    //     'st_penjual',
    //     'jenis_penawaran',
    //     'uraian_barang',
    //     'uang_jaminan',
    //     'nilai_limit',
    //     'nama_pembeli',
    //     'alamat_pembeli',
    //     'no_ktp',
    //     'pokok_lelang',
    //     'bea_penjual',
    //     'bea_pembeli',
    //     'status_lelang'
    // ];

    public function barang(){
        return $this->hasMany("App\Models\Barang");
    }
}
