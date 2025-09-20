<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama_kategori' => 'Undangan',
                'keterangan' => 'Undangan rapat, koordinasi, dlsb.'
            ],
            [
                'nama_kategori' => 'Pengumuman',
                'keterangan' => 'Surat-surat yang terkait dengan pengumuman'
            ],
            [
                'nama_kategori' => 'Nota Dinas',
                'keterangan' => 'Nota dinas internal'
            ],
            [
                'nama_kategori' => 'Pemberitahuan',
                'keterangan' => 'Kategori ini digunakan untuk surat yang sifatnya berupa pengumuman atau menginformasikan suatu perihal.'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
