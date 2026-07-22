<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = Cache::remember('sitemap_xml', now()->addHours(6), function () {
            return $this->generate();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function generate(): string
    {
        $urls = [];

        // Halaman statis
        $staticPages = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => url('/produk'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => url('/tentang'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => url('/kontak'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => url('/cara-belanja'), 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];
        foreach ($staticPages as $page) {
            $urls[] = $page;
        }

        // Category
        Category::select('slug', 'updated_at')->get()->each(function ($Category) use (&$urls) {
            $urls[] = [
                'loc' => url('/Category/' . $Category->slug),
                'lastmod' => $Category->updated_at->toAtomString(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        });

        // Product aktif saja
        Product::where('is_active', true)
            ->select('slug', 'updated_at')
            ->orderByDesc('updated_at')
            ->get()
            ->each(function ($produk) use (&$urls) {
                $urls[] = [
                    'loc' => url('/produk/' . $produk->slug),
                    'lastmod' => $produk->updated_at->toAtomString(),
                    'priority' => '0.7',
                    'changefreq' => 'weekly',
                ];
            });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . "</loc>\n";
            if (isset($url['lastmod'])) {
                $xml .= '    <lastmod>' . $url['lastmod'] . "</lastmod>\n";
            }
            $xml .= '    <changefreq>' . $url['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}