<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create(['nama_kategori' => 'Gaji']);
        Kategori::create(['nama_kategori' => 'Makanan']);
        Kategori::create(['nama_kategori' => 'Transportasi']);
        Kategori::create(['nama_kategori' => 'Hiburan']);
        Kategori::create(['nama_kategori' => 'Kesehatan']);
        Kategori::create(['nama_kategori' => 'Lain-lain']);
    }
}
