<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeoService
{
    public function home(): array
    {
        $title = config('app.name') . ' — Brankas Berkualitas Tahan Api';
        $description = 'Brankas Berkualitas Tahan Api: brankas rumah, brankas toko emas, brankas koperasi, brankas bank, brankas kecil, brankas sedang, brankas besar, dan pintu banker, dibuat dengan material pilihan, dengan keandalan terhadap api dan finishing rapi.';

        return [
            'title'           => $title,
            'metaDescription' => $description,
            'ogTitle'         => $title,
            'ogDescription'   => $description,
            'ogImage'         => $this->defaultImage(),
            'ogType'          => 'website',
            'canonical'       => url('/'),
            'jsonLd'          => [$this->organizationJsonLd(), $this->websiteJsonLd()],
        ];
    }

    public function forProduct(Product $product): array
    {
        $title = $product->meta_title ?: "{$product->name} — " . config('app.name');
        $description = $product->meta_description
            ?: Str::limit(strip_tags($product->short_description ?: $product->description ?: ''), 155);

        $firstImage = $product->images->first();
        $image = $product->og_image
            ? $this->absoluteUrl($product->og_image)
            : ($firstImage ? $this->absoluteUrl($firstImage->image_path) : $this->defaultImage());

        $breadcrumbItems = ['Beranda' => url('/'), 'Produk' => route('produk.index')];
        if ($product->category) {
            $breadcrumbItems[$product->category->name] = route('kategori.show', $product->category->slug);
        }
        $breadcrumbItems[$product->name] = route('produk.show', $product->slug);

        return [
            'title'           => $title,
            'metaDescription' => $description,
            'ogTitle'         => $product->og_title ?: $title,
            'ogDescription'   => $product->og_description ?: $description,
            'ogImage'         => $image,
            'ogType'          => 'product',
            'canonical'       => $product->canonical_url ?: route('produk.show', $product->slug),
            'jsonLd'          => [
                $this->productJsonLd($product, $title, $description, $image),
                $this->breadcrumbJsonLd($breadcrumbItems),
            ],
        ];
    }

    public function forCategory(Category $category): array
    {
        $title = $category->meta_title ?: "{$category->name} — " . config('app.name');
        $description = $category->meta_description
            ?: (strip_tags($category->description ?: '') ?: "Koleksi {$category->name} berkualitas dari " . config('app.name') . '.');
        $description = Str::limit($description, 155);

        $image = $category->og_image ? $this->absoluteUrl($category->og_image) : $this->defaultImage();

        return [
            'title'           => $title,
            'metaDescription' => $description,
            'ogTitle'         => $title,
            'ogDescription'   => $description,
            'ogImage'         => $image,
            'ogType'          => 'website',
            'canonical'       => $category->canonical_url ?: route('kategori.show', $category->slug),
            'jsonLd'          => [
                $this->breadcrumbJsonLd([
                    'Beranda' => url('/'),
                    'Produk'  => route('produk.index'),
                    $category->name => route('kategori.show', $category->slug),
                ]),
            ],
        ];
    }

    public function forPage(string $title, string $description, ?string $image = null, ?string $canonical = null): array
    {
        return [
            'title'           => $title,
            'metaDescription' => $description,
            'ogTitle'         => $title,
            'ogDescription'   => $description,
            'ogImage'         => $image ?: $this->defaultImage(),
            'ogType'          => 'website',
            'canonical'       => $canonical ?: url()->current(),
            'jsonLd'          => [],
        ];
    }

    private function productJsonLd(Product $product, string $name, string $description, string $image): array
    {
        $data = [
            '@context'    => 'https://schema.org/',
            '@type'       => 'Product',
            'name'        => $name,
            'description' => $description,
            'image'       => [$image],
            'sku'         => $product->sku,
            'brand'       => ['@type' => 'Brand', 'name' => config('app.name')],
            'offers'      => [
                '@type'         => 'Offer',
                'url'           => route('produk.show', $product->slug),
                'priceCurrency' => 'IDR',
                'price'         => (string) $product->final_price,
                'availability'  => $product->stock > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
            ],
        ];

        if ($product->review_count > 0) {
            $data['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => (string) $product->average_rating,
                'reviewCount' => (string) $product->review_count,
            ];
        }

        return $data;
    }

    private function breadcrumbJsonLd(array $items): array
    {
        $position = 1;
        $listItems = [];

        foreach ($items as $name => $url) {
            $listItems[] = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $name,
                'item'     => $url,
            ];
        }

        return [
            '@context'        => 'https://schema.org/',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    private function organizationJsonLd(): array
    {
        return [
            '@context' => 'https://schema.org/',
            '@type'    => 'Organization',
            'name'     => config('app.name'),
            'url'      => url('/'),
            'logo'     => $this->defaultImage(),
        ];
    }

    private function websiteJsonLd(): array
    {
        return [
            '@context'        => 'https://schema.org/',
            '@type'           => 'WebSite',
            'name'            => config('app.name'),
            'url'             => url('/'),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => route('produk.index') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    private function absoluteUrl(string $path): string
    {
        return url(Storage::url($path));
    }

    private function defaultImage(): string
    {
        // Ganti dengan path logo/gambar andalan Naima, taruh filenya di public/images/og-default.jpg
        return asset('images/og-default.jpg');
    }
}