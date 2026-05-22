@extends('layouts.app')

@section('title', 'Модерация отзывов | Панель управления')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Модерация отзывов</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Подтверждение или удаление отзывов покупателей о магазине и товарах.</p>
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
            <a href="{{ route('admin.orders') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📦 Заказы
            </a>
            <a href="{{ route('admin.articles') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📰 Статьи / Новости
            </a>
            <a href="{{ route('admin.promotions') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                🔥 Акции / Скидки
            </a>
            <a href="{{ route('admin.reviews') }}" class="btn" style="justify-content: var(--accent-blue); background: var(--accent-blue); color: white; width: 100%;">
                💬 Модерация отзывов
            </a>
            <a href="{{ route('admin.settings') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                ⚙️ Настройки сайта
            </a>
        </div>

        <!-- Main Reviews Moderation Content -->
        <div class="card" style="padding: 40px; background: var(--bg-card);">
            <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                <span>💬</span> Все отзывы покупателей
            </h2>

            @if(session('success'))
                <div class="alert alert-success" style="padding: 12px 16px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($reviews->isEmpty())
                <p style="color: var(--text-secondary); text-align: center; padding: 40px 0;">Отзывов в системе пока нет.</p>
            @else
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($reviews as $rev)
                        <div style="background: var(--bg-input); border: 1px solid {{ $rev->is_approved ? 'var(--border-color)' : 'rgba(239, 68, 68, 0.3)' }}; border-radius: var(--radius-md); padding: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap; margin-bottom: 12px;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                        <h3 style="margin: 0; color: white; font-size: 16px; font-weight: 700;">{{ $rev->user->name ?? 'Покупатель' }}</h3>
                                        <span style="font-size: 11px; font-weight: 700; background: {{ $rev->is_approved ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $rev->is_approved ? 'var(--accent-emerald)' : '#ef4444' }}; border: 1px solid {{ $rev->is_approved ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)' }}; padding: 2px 8px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            {{ $rev->is_approved ? 'Опубликован' : 'Ожидает модерации' }}
                                        </span>
                                    </div>
                                    <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-top: 4px;">
                                        Дата: {{ $rev->created_at->format('d.m.Y H:i') }}
                                        @if($rev->product)
                                            | О товаре: <a href="{{ route('catalog.show', $rev->product->slug) }}" target="_blank" style="color: var(--accent-blue); text-decoration: none; font-weight: 600;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">{{ $rev->product->name }}</a>
                                        @else
                                            | О магазине в целом
                                        @endif
                                    </span>
                                </div>

                                <!-- Stars Rating -->
                                <div style="color: #f59e0b; font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $rev->rating ? '★' : '☆' }}</span>
                                    @endfor
                                    <span style="color: var(--text-secondary); font-size: 13px; font-family: var(--font-body); font-weight: normal; margin-left: 4px;">({{ $rev->rating }}/5)</span>
                                </div>
                            </div>

                            <p style="margin: 0 0 16px 0; color: white; font-size: 14px; line-height: 1.5; white-space: pre-line;">
                                {{ $rev->comment }}
                            </p>

                            <!-- Actions -->
                            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px dashed var(--border-color); padding-top: 16px;">
                                @if(!$rev->is_approved)
                                    <form action="{{ route('admin.reviews.approve', $rev->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-emerald); border: 1px solid rgba(16, 185, 129, 0.2); padding: 8px 16px; font-size: 13px;" onmouseover="this.style.background='rgba(16, 185, 129, 0.2)'" onmouseout="this.style.background='rgba(16, 185, 129, 0.1)'">
                                            ✅ Одобрить и опубликовать
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.reviews.delete', $rev->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот отзыв?')">
                                    @csrf
                                    <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 8px 16px; font-size: 13px;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                                        🗑️ Удалить
                                    </button>
                                </form>
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
        div[style*="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap"] {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
        }
        div[style*="color: #f59e0b"] {
            margin-top: 4px;
        }
    }
</style>
@endsection
