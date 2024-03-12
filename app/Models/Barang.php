<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';

    public function risalahLelang(){
        return $this->belongsTo("App\Models\RisalahLelang");
    }
}
