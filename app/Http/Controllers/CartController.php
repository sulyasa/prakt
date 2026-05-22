<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'size' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        // Unique item key based on product ID and selected size!
        $cartKey = $id . '_' . $request->size;

        $activePrice = $product->promo_price !== null ? $product->promo_price : $product->price;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'price' => $activePrice,
                'size' => $request->size,
                'quantity' => $request->quantity,
                'image_path' => $product->image_path,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Товар успешно добавлен в корзину!');
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Количество товара обновлено!');
        }

        return back()->with('error', 'Товар не найден в корзине.');
    }

    public function remove($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            return back()->with('success', 'Товар удален из корзины!');
        }

        return back()->with('error', 'Товар не найден в корзине.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'delivery_address' => ['required', 'string', 'max:500'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста.');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            // Create Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_price' => $total,
                'delivery_address' => $request->delivery_address,
                'contact_phone' => $request->contact_phone,
                'contact_name' => $request->contact_name,
            ]);

            // Create OrderItems and decrease product stock!
            foreach ($cart as $key => $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    // Check stock
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Недостаточно товара {$product->name} на складе. Доступно: {$product->stock} шт.");
                    }
                    
                    $product->decrement('stock', $item['quantity']);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'size' => $item['size'],
                ]);
            }

            DB::commit();

            // Clear session cart
            session()->forget('cart');

            return redirect()->route('cabinet.orders')->with('success', 'Ваш заказ №' . $order->id . ' успешно оформлен! Вы можете следить за его статусом в личном кабинете.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }
}
