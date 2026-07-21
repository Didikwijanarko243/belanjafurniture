<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\SeoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(SeoService $seoService): View
    {
        $seo = $seoService->home();

        return view('pages.home', array_merge($seo, [
            'categories'       => Category::active()->parentOnly()->orderBy('sort_order')->get(),
            'featuredProducts' => Product::active()->featured()->with('primaryImage')->latest()->take(8)->get(),
            'testimonials'     => [], // sesuaikan kalau sudah ada model Testimonial
        ]));
    }
}