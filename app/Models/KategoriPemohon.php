<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPemohon extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function risalahLelang(){
        return $this->hasmany("App\Models\RisalahLelang");
    }
}
