<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'email_to',
        'document_type',
        'status',
        'additional_info'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
