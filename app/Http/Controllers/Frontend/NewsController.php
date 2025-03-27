<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();

        // Filter Search
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // Sort by Date
        if ($request->has('sort') && $request->sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->has('sort') && $request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        // Paginate the results
        $news = $query->paginate(6); // Tampilkan 6 berita per halaman

        // Ambil 3 berita utama
        $headlineNews = News::orderBy('created_at', 'desc')->take(3)->get();

        // Ambil 3 berita terbaru (tidak termasuk headline)
        $latestNews = News::orderBy('created_at', 'desc')->skip(3)->take(3)->get();

        return view('pages.frontend.news.news', compact('news','headlineNews', 'latestNews'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

        return view('pages.frontend.news.news-detail', compact('news'));
    }

    public function latestNews()
    {
        return News::orderBy('created_at', 'desc')->take(2)->get();
    }
}
