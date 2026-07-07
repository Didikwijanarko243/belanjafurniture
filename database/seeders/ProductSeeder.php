<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sofa Retro 3 Dudukan Kayu Jati',
                'category' => 'Sofa',
                'price' => 4500000,
                'sale_price' => 3950000,
                'stock' => 8,
                'weight' => 35,
                'length' => 180, 'width' => 80, 'height' => 85,
                'material' => 'jati',
                'finishing' => 'natural',
                'is_featured' => true,
                'short_description' => 'Sofa 3 dudukan bergaya retro dengan rangka kayu jati solid dan bantalan busa densitas tinggi.',
                'description' => "Sofa ini dibuat dari kayu jati grade A yang dikeringkan secara alami untuk mencegah retak dan melengkung.\nBantalan menggunakan busa densitas tinggi yang dilapisi kain kanvas tebal, nyaman untuk pemakaian jangka panjang.\nCocok untuk ruang tamu bergaya vintage maupun modern minimalis.",
            ],
            [
                'name' => 'Meja Makan Minimalis 6 Kursi',
                'category' => 'Meja',
                'price' => 6200000,
                'sale_price' => null,
                'stock' => 5,
                'weight' => 45,
                'length' => 160, 'width' => 90, 'height' => 75,
                'material' => 'mahoni',
                'finishing' => 'duco',
                'is_featured' => true,
                'short_description' => 'Meja makan untuk 6 orang dengan desain kaki tapered minimalis dan finishing duco putih matte.',
                'description' => "Set meja makan ini dirancang untuk keluarga menengah, muat hingga 6 kursi dengan nyaman.\nPermukaan meja dilapisi finishing duco tahan gores dan mudah dibersihkan.\nRangka kaki menggunakan kayu mahoni solid yang kokoh menopang beban berat.",
            ],
            [
                'name' => 'Lemari Pakaian 3 Pintu',
                'category' => 'Lemari',
                'price' => 5800000,
                'sale_price' => 5200000,
                'stock' => 4,
                'weight' => 60,
                'length' => 150, 'width' => 60, 'height' => 200,
                'material' => 'jati',
                'finishing' => 'natural',
                'is_featured' => false,
                'short_description' => 'Lemari 3 pintu dengan rak dalam dan laci tambahan, kapasitas simpan luas untuk kamar tidur.',
                'description' => "Lemari ini memiliki 3 pintu ayun, 4 rak susun, dan 2 laci di bagian bawah untuk menyimpan aksesoris kecil.\nEngsel menggunakan hinge soft-close agar tidak berisik saat ditutup.\nFinishing natural menonjolkan serat asli kayu jati.",
            ],
            [
                'name' => 'Kursi Makan Anyaman Rotan',
                'category' => 'Kursi',
                'price' => 850000,
                'sale_price' => null,
                'stock' => 20,
                'weight' => 6,
                'length' => 45, 'width' => 50, 'height' => 90,
                'material' => 'rotan',
                'finishing' => 'natural',
                'is_featured' => true,
                'short_description' => 'Kursi makan dengan sandaran anyaman rotan asli dan kaki kayu jati, ringan dan mudah dipindah.',
                'description' => "Kursi ini memadukan rangka kayu jati dengan anyaman rotan alami pada bagian sandaran dan dudukan.\nDesainnya ringan sehingga mudah dipindahkan, cocok untuk ruang makan bergaya tropis kontemporer.\nDijual satuan, tersedia stok untuk pemesanan set 4-6 kursi.",
            ],
            [
                'name' => 'Rak Buku Dinding 5 Susun',
                'category' => 'Rak',
                'price' => 1450000,
                'sale_price' => null,
                'stock' => 12,
                'weight' => 18,
                'length' => 80, 'width' => 25, 'height' => 180,
                'material' => 'mahoni',
                'finishing' => 'melamik',
                'is_featured' => false,
                'short_description' => 'Rak buku 5 susun model terbuka, cocok untuk ruang kerja atau sudut baca minimalis.',
                'description' => "Rak ini memiliki 5 tingkat susun terbuka dengan kapasitas beban hingga 15kg per rak.\nFinishing melamik memberi tampilan semi-glossy yang tahan lembap.\nUkuran ramping cocok untuk apartemen maupun rumah dengan ruang terbatas.",
            ],
        ];

        foreach ($products as $index => $item) {
            $category = Category::where('name', $item['category'])->first();

            $product = Product::create([
                'category_id' => $category->id,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'sku' => 'FRN-' . strtoupper(Str::random(6)),
                'description' => $item['description'],
                'short_description' => $item['short_description'],
                'price' => $item['price'],
                'sale_price' => $item['sale_price'],
                'stock' => $item['stock'],
                'weight' => $item['weight'],
                'length' => $item['length'],
                'width' => $item['width'],
                'height' => $item['height'],
                'material' => $item['material'],
                'finishing' => $item['finishing'],
                'is_custom_order' => false,
                'is_featured' => $item['is_featured'],
                'is_active' => true,
                'meta_title' => $item['name'] . ' - Furniture Kayu Solid',
                'meta_description' => $item['short_description'],
            ]);

            // Gambar placeholder lokal (SVG bertema toko) — ganti dengan foto asli produk saat sudah tersedia
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/' . Str::slug($item['name']) . '.svg',
                'alt_text' => $product->name,
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }
}
