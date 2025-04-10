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
        } else {
            // Default sort by newest if no sort is specified
            $query->orderBy('created_at', 'desc');
        }

        // Paginate the results
        $news = $query->paginate(6); // Tampilkan 6 berita per halaman

        // Ambil 3 berita utama untuk headline
        $headlineNews = News::orderBy('created_at', 'desc')->take(3)->get();

        // Get headline IDs to exclude from latest news
        $headlineIds = $headlineNews->pluck('id');

        // Ambil berita terbaru (tidak termasuk headline)
        // Make sure we always have data in latestNews
        if ($headlineNews->count() > 0) {
            $latestNews = News::whereNotIn('id', $headlineIds)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        } else {
            $latestNews = News::orderBy('created_at', 'desc')->take(5)->get();
        }

        // Fallback: If still no latest news, just use recent entries
        if ($latestNews->count() == 0) {
            $latestNews = News::orderBy('created_at', 'desc')->take(5)->get();
        }

        return view('pages.frontend.news.news', compact('news', 'headlineNews', 'latestNews'));
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
