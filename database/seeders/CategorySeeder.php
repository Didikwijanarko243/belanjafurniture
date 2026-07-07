<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sofa',
                'description' => 'Sofa kayu solid dengan bantalan busa berkualitas, cocok untuk ruang tamu.',
            ],
            [
                'name' => 'Meja',
                'description' => 'Meja makan, meja kerja, dan meja kopi dari kayu jati dan mahoni pilihan.',
            ],
            [
                'name' => 'Lemari',
                'description' => 'Lemari pakaian dan lemari penyimpanan dengan konstruksi kayu solid.',
            ],
            [
                'name' => 'Kursi',
                'description' => 'Kursi makan, kursi kerja, dan kursi santai dengan berbagai finishing.',
            ],
            [
                'name' => 'Rak',
                'description' => 'Rak buku dan rak dinding minimalis untuk melengkapi ruangan Anda.',
            ],
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
                'sort_order' => $index + 1,
                'meta_title' => $category['name'] . ' Kayu Solid Berkualitas',
                'meta_description' => $category['description'],
            ]);
        }
    }
}
