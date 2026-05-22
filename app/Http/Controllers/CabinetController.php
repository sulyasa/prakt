<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CabinetController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('cabinet.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('cabinet.index')->with('success', 'Личные данные успешно обновлены!');
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('cabinet.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string', 'max:500'],
        ]);

        $user = auth()->user();

        // If this is the first address, make it default!
        $isFirst = $user->addresses()->count() === 0;

        if ($request->boolean('is_default') && !$isFirst) {
            // Remove default flag from all other user addresses
            $user->addresses()->update(['is_default' => false]);
        }

        DeliveryAddress::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'is_default' => $isFirst ? true : $request->boolean('is_default'),
        ]);

        return redirect()->route('cabinet.addresses')->with('success', 'Адрес доставки успешно добавлен!');
    }

    public function deleteAddress($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        
        $wasDefault = $address->is_default;
        $address->delete();

        // If we deleted the default address, set another one as default
        if ($wasDefault) {
            $next = auth()->user()->addresses()->first();
            if ($next) {
                $next->update(['is_default' => true]);
            }
        }

        return redirect()->route('cabinet.addresses')->with('success', 'Адрес доставки удален!');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()
            ->with(['orderItems.product'])
            ->latest()
            ->get();

        return view('cabinet.orders', compact('orders'));
    }
}
