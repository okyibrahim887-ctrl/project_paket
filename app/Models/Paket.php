<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = [
        'nama_penerima',
        'no_wa',
        'nama_satpam',
        'status_cod',
        'harga_cod',
        'catatan',
        'tanggal',
        'status_paket'
    ];
}
