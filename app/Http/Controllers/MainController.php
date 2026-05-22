<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Article;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        // Fetch 4 active products as featured
        $featuredProducts = Product::where('is_active', true)->take(4)->get();
        return view('home', compact('featuredProducts'));
    }

    public function contacts()
    {
        return view('contacts');
    }

    public function articles()
    {
        $articles = Article::latest()->get();
        return view('articles', compact('articles'));
    }

    public function articleShow($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('article_show', compact('article'));
    }

    public function promotions()
    {
        $promotions = Promotion::latest()->get();
        return view('promotions', compact('promotions'));
    }

    public function reviews()
    {
        // Store reviews are where product_id is null and are approved
        $reviews = Review::with('user')
            ->whereNull('product_id')
            ->where('is_approved', true)
            ->latest()
            ->get();
            
        return view('reviews', compact('reviews'));
    }

    public function reviewStore(Request $request)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => null, // Store-wide review
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Requires admin moderation!
        ]);

        return back()->with('success', 'Спасибо за ваш отзыв! Он появится на сайте после модерации администратором.');
    }
}
