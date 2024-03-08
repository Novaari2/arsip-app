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
        return $this->hasMany("App\Models\Barang");
    }

    public function gudang(){
        return $this->belongsTo("App\Models\RakGudang");
    }
}
