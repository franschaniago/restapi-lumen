<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama', 'harga', 'warna', 'kondisi', 'deskripsi',
    ];

}
