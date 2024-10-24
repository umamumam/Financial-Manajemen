<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'reminder_date',
        'is_paid', // status apakah pengingat sudah dibayar
    ];

    protected $casts = [
        'reminder_date' => 'date', // konversi kolom tanggal ke format date
    ];
}