<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RisalahLelang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'buku_registers';

    public function barang(){
        return $this->hasMany("App\Models\Barang", "risalah_lelang_id", "id");
    }

    public function rakGudang(){
        return $this->belongsTo("App\Models\RakGudang");
    }

    public function rakGudangDetail()
    {
        return $this->belongsTo("App\Models\RakGudangDetail");
    }

    public function pejabatLelang(){
        return $this->belongsTo("App\Models\PejabatLelang");
    }

    public function jenisLelang(){
        return $this->belongsTo("App\Models\JenisLelang");
    }
}
