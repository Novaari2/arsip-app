<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RakGudang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_gudang'
    ];

    public function rakGudangDetails(){
        return $this->hasMany("App\Models\RakGudangDetail");
    }
}
