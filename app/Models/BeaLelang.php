<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeaLelang extends Model
{
    use HasFactory;
    protected $table = 'bea_lelangs';
    protected $fillable = [
        'id',
        'nama',
        'tipe',
        'bea_penjual',
        'bea_pembeli',
    ];
}
