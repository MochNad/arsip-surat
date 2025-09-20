<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Letter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengumuman = Category::where('nama_kategori', 'Pengumuman')->first();
        $undangan = Category::where('nama_kategori', 'Undangan')->first();

        Letter::create([
            'nomor_surat' => '2022/PD3/TU/001',
            'category_id' => $pengumuman->id,
            'judul' => 'Nota Dinas WFH',
            'file_path' => 'letters/sample1.pdf',
            'file_name' => 'nota_dinas_wfh.pdf',
            'created_at' => '2023-06-21 17:23:00'
        ]);

        Letter::create([
            'nomor_surat' => '2022/PD2/TU/022',
            'category_id' => $undangan->id,
            'judul' => 'Undangan Halal Bi Halal',
            'file_path' => 'letters/sample2.pdf',
            'file_name' => 'undangan_halal_bi_halal.pdf',
            'created_at' => '2023-04-21 18:23:00'
        ]);
    }
}
