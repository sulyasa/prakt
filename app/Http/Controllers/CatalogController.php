<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filter by Category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by Brand
        if ($request->filled('brands') && is_array($request->brands)) {
            $query->whereIn('brand', $request->brands);
        }

        // Filter by Size
        if ($request->filled('sizes') && is_array($request->sizes)) {
            $query->where(function($q) use ($request) {
                foreach($request->sizes as $size) {
                    $q->orWhere('sizes', 'like', '%' . $size . '%');
                }
            });
        }

        // Filter by Price Range
        if ($request->filled('price_min')) {
            $query->where(function($q) use ($request) {
                $q->where(function($sub) use ($request) {
                    $sub->whereNull('promo_price')->where('price', '>=', $request->price_min);
                })->orWhere(function($sub) use ($request) {
                    $sub->whereNotNull('promo_price')->where('promo_price', '>=', $request->price_min);
                });
            });
        }

        if ($request->filled('price_max')) {
            $query->where(function($q) use ($request) {
                $q->where(function($sub) use ($request) {
                    $sub->whereNull('promo_price')->where('price', '<=', $request->price_max);
                })->orWhere(function($sub) use ($request) {
                    $sub->whereNotNull('promo_price')->where('promo_price', '<=', $request->price_max);
                });
            });
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(promo_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(promo_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'ASC');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'DESC');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Fetch categories & unique brands for filters
        $categories = Category::all();
        $brands = Product::where('is_active', true)->distinct()->pluck('brand')->toArray();
        
        // Typical sportswear sizes to list in sidebar filter
        $availableSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '40', '41', '42', '43', '44'];

        return view('catalog', compact('products', 'categories', 'brands', 'availableSizes'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'reviews' => function($q) {
            $q->where('is_approved', true)->with('user')->latest();
        }])->where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('product_show', compact('product'));
    }

    public function reviewStore(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Requires moderation
        ]);

        return back()->with('success', 'Отзыв о товаре успешно отправлен! Он появится на странице после модерации администратором.');
    }
}
