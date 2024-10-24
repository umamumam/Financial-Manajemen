<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    use HasFactory;

    // Menambahkan properti fillable untuk mass assignment
    protected $fillable = [
        'kategori_id',
        'jumlah',
        'deskripsi',
        'tanggal',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
