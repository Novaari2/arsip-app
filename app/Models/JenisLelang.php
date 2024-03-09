<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLelang extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function risalahLelang()
    {
        return $this->hasMany("App\Models\RisalahLelang");
    }
}
