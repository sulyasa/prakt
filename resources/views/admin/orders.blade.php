@extends('layouts.app')

@section('title', 'Управление заказами | Панель управления')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Управление заказами</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Просмотр всех заказов интернет-магазина и изменение их статусов.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background: var(--bg-card); color: white; border: 1px solid var(--border-color); font-weight: 600; gap: 8px;">
            📊 Панель управления
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 280px 1fr; gap: 32px; align-items: start;">
        <!-- Admin Sidebar Navigation -->
        <div class="card" style="padding: 20px; background: var(--bg-card); display: flex; flex-direction: column; gap: 8px;">
            <div style="padding: 12px; border-bottom: 1px solid var(--border-color); margin-bottom: 12px; text-align: center;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; font-size: 28px; font-weight: 700; color: white;">
                    ⚙️
                </div>
                <h3 style="margin: 0; color: white; font-size: 16px; font-weight: 600;">Администратор</h3>
                <span style="font-size: 12px; color: var(--text-secondary);">Управление сайтом</span>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📊 Главная панель
            </a>
            <a href="{{ route('admin.categories') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📁 Категории
            </a>
            <a href="{{ route('admin.products') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                👕 Товары каталога
            </a>
            <a href="{{ route('admin.orders') }}" class="btn" style="justify-content: var(--accent-blue); background: var(--accent-blue); color: white; width: 100%;">
                📦 Заказы
            </a>
            <a href="{{ route('admin.articles') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📰 Статьи / Новости
            </a>
            <a href="{{ route('admin.promotions') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                🔥 Акции / Скидки
            </a>
            <a href="{{ route('admin.reviews') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                💬 Модерация отзывов
            </a>
            <a href="{{ route('admin.settings') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                ⚙️ Настройки сайта
            </a>
        </div>

        <!-- Main Orders Management Content -->
        <div class="card" style="padding: 40px; background: var(--bg-card);">
            <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                <span>📦</span> Список всех заказов
            </h2>

            @if(session('success'))
                <div class="alert alert-success" style="padding: 12px 16px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($orders->isEmpty())
                <p style="color: var(--text-secondary); text-align: center; padding: 40px 0;">Заказы в системе отсутствуют.</p>
            @else
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    @foreach($orders as $order)
                        <div style="border: 1px solid var(--border-color); border-radius: var(--radius-md); background: var(--bg-input); overflow: hidden;">
                            <!-- Order Header -->
                            <div style="padding: 20px; border-bottom: 1px solid var(--border-color); background: rgba(255,255,255,0.02); display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
                                <div>
                                    <h3 style="margin: 0; color: white; font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                        Заказ №{{ 1000 + $order->id }} 
                                        @php
                                            $badgeColor = 'var(--text-secondary)';
                                            $badgeBg = 'rgba(255,255,255,0.05)';
                                            
                                            switch($order->status) {
                                                case 'Новый':
                                                case 'pending':
                                                    $badgeColor = 'var(--accent-blue)';
                                                    $badgeBg = 'rgba(59, 130, 246, 0.1)';
                                                    break;
                                                case 'Принят':
                                                case 'processing':
                                                    $badgeColor = '#f59e0b';
                                                    $badgeBg = 'rgba(245, 158, 11, 0.1)';
                                                    break;
                                                case 'В пути':
                                                    $badgeColor = '#a855f7';
                                                    $badgeBg = 'rgba(168, 85, 247, 0.1)';
                                                    break;
                                                case 'Доставлен':
                                                case 'completed':
                                                    $badgeColor = 'var(--accent-emerald)';
                                                    $badgeBg = 'rgba(16, 185, 129, 0.1)';
                                                    break;
                                                case 'Отменен':
                                                case 'cancelled':
                                                    $badgeColor = '#ef4444';
                                                    $badgeBg = 'rgba(239, 68, 68, 0.1)';
                                                    break;
                                            }
                                        @endphp
                                        <span style="font-size: 11px; font-weight: 700; background: {{ $badgeBg }}; color: {{ $badgeColor }}; border: 1px solid {{ str_replace('0.1', '0.2', $badgeBg) }}; padding: 2px 8px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            {{ $order->status }}
                                        </span>
                                    </h3>
                                    <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-top: 4px;">
                                        от {{ $order->created_at->format('d.m.Y H:i') }} | Клиент: <strong style="color: white;">{{ $order->user->name ?? 'Гость' }}</strong> ({{ $order->user->email ?? 'no-email' }})
                                        @if(!empty($order->user->phone))
                                            | Тел: <strong style="color: white;">{{ $order->user->phone }}</strong>
                                        @endif
                                    </span>
                                </div>

                                <!-- Status Updater Form -->
                                <div>
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" style="display: flex; gap: 8px; align-items: center;">
                                        @csrf
                                        <select name="status" style="background: var(--bg-card); color: white; border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 8px 12px; font-size: 13px; outline: none; cursor: pointer;">
                                            <option value="pending" {{ $order->status == 'pending' || $order->status == 'Новый' ? 'selected' : '' }}>Новый</option>
                                            <option value="processing" {{ $order->status == 'processing' || $order->status == 'Принят' ? 'selected' : '' }}>Принят / В обработке</option>
                                            <option value="completed" {{ $order->status == 'completed' || $order->status == 'Доставлен' ? 'selected' : '' }}>Выполнен / Доставлен</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' || $order->status == 'Отменен' ? 'selected' : '' }}>Отменен</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px;">
                                            Обновить статус
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div style="padding: 20px;">
                                <div style="margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <span style="font-size: 12px; font-weight: 700; color: white; display: block; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            📍 Адрес доставки:
                                        </span>
                                        <p style="margin: 0; color: var(--text-secondary); font-size: 14px; line-height: 1.5;">
                                            {{ $order->delivery_address }}
                                        </p>
                                    </div>
                                    <div style="text-align: right;">
                                        <span style="font-size: 12px; color: var(--text-secondary); display: block;">Итоговая стоимость</span>
                                        <span style="font-size: 20px; font-weight: 800; color: var(--accent-emerald);">
                                            {{ number_format($order->total_price, 0, '.', ' ') }} ₽
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <span style="font-size: 12px; font-weight: 700; color: white; display: block; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        🛍️ Состав заказа:
                                    </span>
                                    
                                    <div style="display: flex; flex-direction: column; gap: 12px;">
                                        @foreach($order->orderItems as $item)
                                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; border-bottom: 1px dashed var(--border-color); padding-bottom: 12px; flex-wrap: wrap;">
                                                <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 200px;">
                                                    <div style="width: 40px; height: 40px; background: var(--bg-card); border-radius: var(--radius-sm); border: 1px solid var(--border-color); overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                                        @if($item->product && $item->product->image_path && file_exists(public_path($item->product->image_path)))
                                                            <img src="{{ asset($item->product->image_path) }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        @else
                                                            👕
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if($item->product)
                                                            <a href="{{ route('catalog.show', $item->product->slug) }}" target="_blank" style="color: white; font-weight: 600; text-decoration: none; font-size: 14px; transition: color 0.2s ease;" onmouseover="this.style.color='var(--accent-blue)'" onmouseout="this.style.color='white'">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        @else
                                                            <span style="color: white; font-weight: 600; font-size: 14px;">Товар удален из каталога</span>
                                                        @endif
                                                        <span style="display: block; font-size: 11px; color: var(--text-secondary); margin-top: 2px;">
                                                            Размер: <strong style="color: white;">{{ $item->size }}</strong> | Бренд: <strong style="color: white;">{{ $item->product->brand ?? 'Бренд' }}</strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <div style="text-align: right; display: flex; align-items: center; gap: 24px;">
                                                    <span style="color: var(--text-secondary); font-size: 13px;">
                                                        {{ number_format($item->price, 0, '.', ' ') }} ₽ × {{ $item->quantity }}
                                                    </span>
                                                    <span style="color: white; font-weight: 700; font-size: 14px; min-width: 80px; text-align: right;">
                                                        {{ number_format($item->price * $item->quantity, 0, '.', ' ') }} ₽
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @media (max-width: 992px) {
        div[style*="display: grid; grid-template-columns: 280px 1fr"] {
            grid-template-columns: 1fr !important;
        }
        div[style*="justify-content: space-between; align-items: flex-start; flex-wrap: wrap"] {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        div[style*="justify-content: space-between; align-items: flex-start; flex-wrap: wrap"] form {
            margin-top: 12px;
            width: 100%;
        }
        div[style*="display: grid; grid-template-columns: 1fr 1fr; gap: 20px"] {
            grid-template-columns: 1fr !important;
        }
        div[style*="text-align: right"] {
            text-align: left !important;
            margin-top: 8px;
        }
    }
</style>
@endsection
