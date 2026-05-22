<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Article;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // 1. Dashboard
    public function dashboard()
    {
        $totalSales = Order::where('status', 'completed')->sum('total_price');
        $totalOrdersCount = Order::count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingReviewsCount = Review::where('is_approved', false)->count();

        // Recent orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales', 'totalOrdersCount', 'pendingOrdersCount', 
            'totalUsers', 'pendingReviewsCount', 'recentOrders'
        ));
    }

    // 2. Categories CRUD
    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Категория успешно создана!');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id],
            'description' => ['nullable', 'string'],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Категория обновлена!');
    }

    public function categoryDestroy($id)
    {
        $category = Category::findOrFail($id);
        
        // This will cascade delete products due to database cascade migrations
        $category->delete();

        return back()->with('success', 'Категория и все связанные товары удалены!');
    }

    // 3. Products CRUD
    public function products()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();
        return view('admin.products', compact('products', 'categories'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'promo_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'brand' => ['required', 'string', 'max:255'],
            'sizes' => ['required', 'string'], // e.g. 'S, M, L'
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(100, 999), // guarantee unique slug
            'description' => $request->description,
            'price' => $request->price,
            'promo_price' => $request->promo_price,
            'brand' => $request->brand,
            'sizes' => $request->sizes,
            'image_path' => $imagePath,
            'stock' => $request->stock,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Товар успешно добавлен!');
    }

    public function productUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'promo_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'brand' => ['required', 'string', 'max:255'],
            'sizes' => ['required', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path && file_exists(public_path($product->image_path))) {
                @unlink(public_path($product->image_path));
            }
            
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'promo_price' => $request->promo_price,
            'brand' => $request->brand,
            'sizes' => $request->sizes,
            'image_path' => $imagePath,
            'stock' => $request->stock,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Товар обновлен!');
    }

    public function productDestroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image_path && file_exists(public_path($product->image_path))) {
            @unlink(public_path($product->image_path));
        }

        $product->delete();

        return back()->with('success', 'Товар удален!');
    }

    // 4. Orders Management
    public function orders()
    {
        $orders = Order::with(['user', 'orderItems.product'])->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function orderUpdateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Статус заказа №' . $order->id . ' изменен на "' . $request->status . '"!');
    }

    // 5. Articles Management
    public function articles()
    {
        $articles = Article::latest()->get();
        return view('admin.articles', compact('articles'));
    }

    public function articleStore(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/articles'), $imageName);
            $imagePath = 'uploads/articles/' . $imageName;
        }

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(10, 99),
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Статья успешно опубликована!');
    }

    public function articleUpdate(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagePath = $article->image_path;
        if ($request->hasFile('image')) {
            if ($article->image_path && file_exists(public_path($article->image_path))) {
                @unlink(public_path($article->image_path));
            }
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/articles'), $imageName);
            $imagePath = 'uploads/articles/' . $imageName;
        }

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return back()->with('success', 'Статья успешно обновлена!');
    }

    public function articleDestroy($id)
    {
        $article = Article::findOrFail($id);
        
        if ($article->image_path && file_exists(public_path($article->image_path))) {
            @unlink(public_path($article->image_path));
        }

        $article->delete();

        return back()->with('success', 'Статья удалена!');
    }

    // 6. Promotions Management
    public function promotions()
    {
        $promotions = Promotion::latest()->get();
        return view('admin.promotions', compact('promotions'));
    }

    public function promotionStore(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'discount_percent' => ['nullable', 'integer', 'min:1', 'max:99'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/promotions'), $imageName);
            $imagePath = 'uploads/promotions/' . $imageName;
        }

        Promotion::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(10, 99),
            'description' => $request->description,
            'discount_percent' => $request->discount_percent,
            'image_path' => $imagePath,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success', 'Акция создана!');
    }

    public function promotionUpdate(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'discount_percent' => ['nullable', 'integer', 'min:1', 'max:99'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $imagePath = $promotion->image_path;
        if ($request->hasFile('image')) {
            if ($promotion->image_path && file_exists(public_path($promotion->image_path))) {
                @unlink(public_path($promotion->image_path));
            }
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/promotions'), $imageName);
            $imagePath = 'uploads/promotions/' . $imageName;
        }

        $promotion->update([
            'title' => $request->title,
            'description' => $request->description,
            'discount_percent' => $request->discount_percent,
            'image_path' => $imagePath,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success', 'Акция обновлена!');
    }

    public function promotionDestroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        
        if ($promotion->image_path && file_exists(public_path($promotion->image_path))) {
            @unlink(public_path($promotion->image_path));
        }

        $promotion->delete();

        return back()->with('success', 'Акция удалена!');
    }

    // 7. Review Moderation
    public function reviews()
    {
        $reviews = Review::with(['user', 'product'])->latest()->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function reviewApprove($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Отзыв успешно подтвержден и опубликован!');
    }

    public function reviewDestroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return back()->with('success', 'Отзыв удален!');
    }

    // 8. Contact Settings Management
    public function settings()
    {
        $settings = Setting::all();
        return view('admin.settings', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $request->validate([
            'settings' => ['required', 'array'],
        ]);

        foreach ($request->settings as $id => $value) {
            $setting = Setting::findOrFail($id);
            $setting->update(['value' => $value]);
        }

        return back()->with('success', 'Контактные данные магазина успешно обновлены!');
    }
}
