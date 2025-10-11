<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportWpUsersSeeder extends Seeder
{
    public function run()
    {
        // Path file CSV di public/
        $filePath = public_path('wp_users_export.csv');

        // Buka file CSV
        $file = fopen($filePath, 'r');
        $isHeader = true;

        while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
            if ($isHeader) {
                $isHeader = false; // Lewati baris header
                continue;
            }

            // Pastikan baris memiliki jumlah kolom yang benar
            if (count($row) < 6) {
                continue; // Skip baris yang tidak lengkap
            }

            // Generate UUID baru untuk `id`
            $uuid = Str::uuid()->toString();

            // Masukkan data ke tabel `users`
            DB::table('users')->insert([
                'id' => $uuid,
                'old_id' => $row[0], // id lama dari WordPress
                'name' => $row[1],
                'email' => $row[2],
                'created_at' => $row[3],
                'updated_at' => $row[4],
                'password' => $row[5],
            ]);
        }

        fclose($file); // Tutup file setelah selesai
    }
}
