<?php
namespace App\Http\Controllers;

class PageController extends Controller
{
    public function tentang()
    {
        $seo = app(\App\Services\SeoService::class)->forPage(
            'Tentang Kami - ' . config('app.name'),
            'Kenali lebih dekat Naima Furniture, pembuat furniture kayu solid berkualitas.'
        );

        return view('pages.tentang', $seo);
    }

    public function kontak()
    {
        $seo = app(\App\Services\SeoService::class)->forPage(
            'Kontak - ' . config('app.name'),
            'Hubungi Naima Furniture via WhatsApp, email, atau kunjungi workshop kami di Jombang untuk konsultasi produk dan custom order.'
        );

        return view('pages.kontak', $seo);
        
    }
    public function caraBelanja()
    {
        $seo = app(\App\Services\SeoService::class)->forPage(
            'Cara Belanja - ' . config('app.name'),
            'Panduan lengkap cara belanja furniture kayu di Naima Furniture, mulai dari memilih produk hingga proses pengiriman ke rumah Anda.'
        );

        return view('pages.cara-belanja', $seo);
        
  
    }
}
