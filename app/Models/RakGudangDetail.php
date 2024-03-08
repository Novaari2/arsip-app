<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RakGudangDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'rak_gudang_id',
        'no_rak'
    ];

    public function rakGudang()
    {
        return $this->belongsTo("App\Models\RakGudang");
    }
}
