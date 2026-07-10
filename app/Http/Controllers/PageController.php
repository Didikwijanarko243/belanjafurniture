<?php
namespace App\Http\Controllers;

class PageController extends Controller
{
    public function tentang()
    {
        return view('pages.tentang', [
            'title'           => 'Tentang Kami — ' . config('app.name'),
            'metaDescription' => 'Naima Furniture adalah produsen furniture kayu solid asal Jombang, dikerjakan oleh pengrajin lokal untuk rumah yang terasa hangat.',
        ]);
    }

    public function kontak()
    {
        return view('pages.kontak', [
            'title'           => 'Kontak — ' . config('app.name'),
            'metaDescription' => 'Hubungi Naima Furniture via WhatsApp, email, atau kunjungi workshop kami di Jombang untuk konsultasi produk dan custom order.',
        ]);
    }
}
