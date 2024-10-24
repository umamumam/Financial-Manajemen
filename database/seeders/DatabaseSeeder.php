<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\KategoriSeeder; // Menambahkan KategoriSeeder

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan seeder kategori
        $this->call([
            KategoriSeeder::class,
            // Anda dapat menambahkan seeder lain di sini jika diperlukan
        ]);

        // Membuat user test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
