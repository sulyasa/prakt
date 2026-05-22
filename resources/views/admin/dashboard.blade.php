@extends('layouts.app')

@section('title', 'Панель управления | Velocity Sport')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Панель управления</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Добро пожаловать в административную часть интернет-магазина!</p>
        </div>
        <a href="{{ route('cabinet.index') }}" class="btn" style="background: var(--bg-card); color: white; border: 1px solid var(--border-color); font-weight: 600; gap: 8px;">
            👤 Личный кабинет
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

            <a href="{{ route('admin.dashboard') }}" class="btn" style="justify-content: flex-start; background: var(--accent-blue); color: white; width: 100%;">
                📊 Главная панель
            </a>
            <a href="{{ route('admin.categories') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📁 Категории
            </a>
            <a href="{{ route('admin.products') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                👕 Товары каталога
            </a>
            <a href="{{ route('admin.orders') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📦 Заказы
                @if($pendingOrdersCount > 0)
                    <span style="background: #f59e0b; color: white; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 10px; margin-left: auto;">
                        {{ $pendingOrdersCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.articles') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📰 Статьи / Новости
            </a>
            <a href="{{ route('admin.promotions') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                🔥 Акции / Скидки
            </a>
            <a href="{{ route('admin.reviews') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                💬 Модерация отзывов
                @if($pendingReviewsCount > 0)
                    <span style="background: #ef4444; color: white; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 10px; margin-left: auto;">
                        {{ $pendingReviewsCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.settings') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                ⚙️ Настройки сайта
            </a>
        </div>

        <!-- Main Dashboard Content -->
        <div style="display: flex; flex-direction: column; gap: 32px;">
            <!-- Metrics Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
                <!-- Total Sales -->
                <div class="card" style="padding: 24px; background: var(--bg-card); border-left: 4px solid var(--accent-emerald);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="color: var(--text-secondary); font-size: 13px; font-weight: 700; text-transform: uppercase;">Общая выручка</span>
                        <span style="font-size: 24px;">💰</span>
                    </div>
                    <h2 style="font-size: 26px; color: white; margin: 0; font-family: var(--font-heading);">
                        {{ number_format($totalSales, 0, '.', ' ') }} ₽
                    </h2>
                </div>

                <!-- Total Orders -->
                <div class="card" style="padding: 24px; background: var(--bg-card); border-left: 4px solid var(--accent-blue);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="color: var(--text-secondary); font-size: 13px; font-weight: 700; text-transform: uppercase;">Всего заказов</span>
                        <span style="font-size: 24px;">📦</span>
                    </div>
                    <h2 style="font-size: 26px; color: white; margin: 0; font-family: var(--font-heading);">
                        {{ $totalOrdersCount }}
                    </h2>
                </div>

                <!-- Registered Users -->
                <div class="card" style="padding: 24px; background: var(--bg-card); border-left: 4px solid #a855f7;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="color: var(--text-secondary); font-size: 13px; font-weight: 700; text-transform: uppercase;">Покупатели</span>
                        <span style="font-size: 24px;">👥</span>
                    </div>
                    <h2 style="font-size: 26px; color: white; margin: 0; font-family: var(--font-heading);">
                        {{ $totalUsers }}
                    </h2>
                </div>

                <!-- Reviews Moderation -->
                <div class="card" style="padding: 24px; background: var(--bg-card); border-left: 4px solid #ef4444;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="color: var(--text-secondary); font-size: 13px; font-weight: 700; text-transform: uppercase;">Новые отзывы</span>
                        <span style="font-size: 24px;">💬</span>
                    </div>
                    <h2 style="font-size: 26px; color: white; margin: 0; font-family: var(--font-heading); display: flex; align-items: center; gap: 8px;">
                        {{ $pendingReviewsCount }}
                        @if($pendingReviewsCount > 0)
                            <span style="font-size: 11px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 2px 8px; border-radius: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                Требует внимания
                            </span>
                        @endif
                    </h2>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="card" style="padding: 40px; background: var(--bg-card);">
                <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                    <span>📦</span> Последние заказы
                </h2>

                @if($recentOrders->isEmpty())
                    <div style="text-align: center; padding: 40px 20px; color: var(--text-secondary);">
                        <span style="font-size: 40px; display: block; margin-bottom: 12px;">📭</span>
                        Заказов пока не поступало.
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <th style="padding: 12px 16px; color: white; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Заказ</th>
                                    <th style="padding: 12px 16px; color: white; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Клиент</th>
                                    <th style="padding: 12px 16px; color: white; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Дата</th>
                                    <th style="padding: 12px 16px; color: white; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Сумма</th>
                                    <th style="padding: 12px 16px; color: white; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.01)'" onmouseout="this.style.background='transparent'">
                                        <td style="padding: 16px; color: white; font-weight: 600;">
                                            №{{ 1000 + $order->id }}
                                        </td>
                                        <td style="padding: 16px; color: var(--text-secondary);">
                                            <div style="color: white; font-weight: 600;">{{ $order->user->name ?? 'Гость' }}</div>
                                            <div style="font-size: 12px;">{{ $order->user->email ?? '' }}</div>
                                        </td>
                                        <td style="padding: 16px; color: var(--text-secondary); font-size: 13px;">
                                            {{ $order->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td style="padding: 16px; color: var(--accent-emerald); font-weight: 700;">
                                            {{ number_format($order->total_price, 0, '.', ' ') }} ₽
                                        </td>
                                        <td style="padding: 16px;">
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
                        <a href="{{ route('admin.orders') }}" style="color: var(--accent-blue); text-decoration: none; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            Все заказы каталога &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="display: grid; grid-template-columns: 280px 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
