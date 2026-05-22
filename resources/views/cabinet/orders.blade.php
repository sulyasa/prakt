@extends('layouts.app')

@section('title', 'Мои заказы | Velocity Sport')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Личный кабинет</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Отслеживайте статусы ваших заказов и историю покупок.</p>
        </div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="btn" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; font-weight: 700; gap: 8px;">
                ⚙️ Панель администратора
            </a>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: 280px 1fr; gap: 32px; align-items: start;">
        <!-- Sidebar Navigation -->
        <div class="card" style="padding: 20px; background: var(--bg-card); display: flex; flex-direction: column; gap: 8px;">
            <div style="padding: 12px; border-bottom: 1px solid var(--border-color); margin-bottom: 12px; text-align: center;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, var(--accent-blue), var(--accent-emerald)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; font-size: 28px; font-weight: 700; color: white;">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <h3 style="margin: 0; color: white; font-size: 16px; font-weight: 600;">{{ auth()->user()->name }}</h3>
                <span style="font-size: 12px; color: var(--text-secondary);">{{ auth()->user()->email }}</span>
            </div>

            <a href="{{ route('cabinet.index') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                👤 Личные данные
            </a>
            <a href="{{ route('cabinet.addresses') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📍 Адреса доставки
            </a>
            <a href="{{ route('cabinet.orders') }}" class="btn" style="justify-content: var(--accent-blue); background: var(--accent-blue); color: white; width: 100%;">
                📦 Мои заказы
            </a>

            <form action="{{ route('logout') }}" method="POST" style="margin-top: 16px; border-top: 1px solid var(--border-color); padding-top: 16px;">
                @csrf
                <button type="submit" class="btn" style="width: 100%; justify-content: center; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                    🚪 Выйти из аккаунта
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="card" style="padding: 40px; background: var(--bg-card);">
            <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                <span>📦</span> История ваших заказов
            </h2>

            @if($orders->isEmpty())
                <div style="text-align: center; padding: 60px 20px; color: var(--text-secondary);">
                    <span style="font-size: 48px; display: block; margin-bottom: 16px;">🛍️</span>
                    <p style="margin: 0 0 16px 0; font-size: 16px;">Вы еще не совершили ни одной покупки в нашем магазине.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="display: inline-flex;">
                        🛍️ Перейти в каталог
                    </a>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    @foreach($orders as $order)
                        <div style="border: 1px solid var(--border-color); border-radius: var(--radius-md); background: var(--bg-input); overflow: hidden;">
                            <!-- Order Header -->
                            <div style="padding: 20px; border-bottom: 1px solid var(--border-color); background: rgba(255,255,255,0.02); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                                <div>
                                    <h3 style="margin: 0; color: white; font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                                        Заказ №{{ 1000 + $order->id }} 
                                        @php
                                            $badgeColor = 'var(--text-secondary)';
                                            $badgeBg = 'rgba(255,255,255,0.05)';
                                            $statusText = $order->status;
                                            
                                            switch($order->status) {
                                                case 'Новый':
                                                    $badgeColor = 'var(--accent-blue)';
                                                    $badgeBg = 'rgba(59, 130, 246, 0.1)';
                                                    break;
                                                case 'Принят':
                                                    $badgeColor = '#f59e0b';
                                                    $badgeBg = 'rgba(245, 158, 11, 0.1)';
                                                    break;
                                                case 'В пути':
                                                    $badgeColor = '#a855f7';
                                                    $badgeBg = 'rgba(168, 85, 247, 0.1)';
                                                    break;
                                                case 'Доставлен':
                                                    $badgeColor = 'var(--accent-emerald)';
                                                    $badgeBg = 'rgba(16, 185, 129, 0.1)';
                                                    break;
                                                case 'Отменен':
                                                    $badgeColor = '#ef4444';
                                                    $badgeBg = 'rgba(239, 68, 68, 0.1)';
                                                    break;
                                            }
                                        @endphp
                                        <span style="font-size: 11px; font-weight: 700; background: {{ $badgeBg }}; color: {{ $badgeColor }}; border: 1px solid {{ str_replace('0.1', '0.2', $badgeBg) }}; padding: 2px 8px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            {{ $statusText }}
                                        </span>
                                    </h3>
                                    <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-top: 4px;">
                                        от {{ $order->created_at->format('d.m.Y H:i') }}
                                    </span>
                                </div>
                                
                                <div style="text-align: right;">
                                    <span style="font-size: 12px; color: var(--text-secondary); display: block;">Итоговая стоимость</span>
                                    <span style="font-size: 18px; font-weight: 800; color: var(--accent-emerald);">
                                        {{ number_format($order->total_price, 0, '.', ' ') }} ₽
                                    </span>
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div style="padding: 20px;">
                                <div style="margin-bottom: 20px;">
                                    <span style="font-size: 12px; font-weight: 700; color: white; display: block; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        📍 Адрес доставки:
                                    </span>
                                    <p style="margin: 0; color: var(--text-secondary); font-size: 14px; line-height: 1.5;">
                                        {{ $order->delivery_address }}
                                    </p>
                                </div>

                                <div>
                                    <span style="font-size: 12px; font-weight: 700; color: white; display: block; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        🛍️ Товары в заказе:
                                    </span>
                                    
                                    <div style="display: flex; flex-direction: column; gap: 12px;">
                                        @foreach($order->orderItems as $item)
                                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; border-bottom: 1px dashed var(--border-color); padding-bottom: 12px; flex-wrap: wrap;">
                                                <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 200px;">
                                                    <div style="width: 48px; height: 48px; background: var(--bg-card); border-radius: var(--radius-sm); border: 1px solid var(--border-color); overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ asset('uploads/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        @else
                                                            👕
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if($item->product)
                                                            <a href="{{ route('catalog.show', $item->product->slug) }}" style="color: white; font-weight: 600; text-decoration: none; font-size: 14px; transition: color 0.2s ease;" onmouseover="this.style.color='var(--accent-blue)'" onmouseout="this.style.color='white'">
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
    @media (max-width: 768px) {
        div[style*="display: grid; grid-template-columns: 280px 1fr"] {
            grid-template-columns: 1fr !important;
        }
        div[style*="justify-content: space-between; align-items: center; flex-wrap: wrap"] {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        div[style*="text-align: right"] {
            text-align: left !important;
            margin-top: 8px;
        }
    }
</style>
@endsection
