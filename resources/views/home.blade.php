@extends('layouts.app')

@section('title', 'Магазин спортивной одежды Velocity | Главная')

@section('content')
    <!-- Sleek Hero Banner -->
    <div class="hero-banner">
        <span class="hero-subtitle">Новая коллекция 2026</span>
        <h1 class="hero-title">Раскрой свой спортивный потенциал</h1>
        <p class="hero-description">Экипировка от лучших мировых брендов для бега, фитнеса и активного отдыха. Только оригинальная продукция с гарантией качества.</p>
        <div>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="font-size: 16px; padding: 12px 28px;">Перейти в каталог</a>
        </div>
    </div>

    <!-- Core Advantages (Mission & Perks) -->
    <div class="features-section">
        <h2 class="section-title">Почему выбирают <span>Velocity</span></h2>
        
        <div class="grid-3" style="margin-top: 40px;">
            <div class="card" style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 16px; color: var(--accent-emerald);">🛡️</div>
                <h3 style="margin-bottom: 12px;">100% Оригинал</h3>
                <p style="color: var(--text-secondary); font-size: 14px;">Мы работаем напрямую с официальными дистрибьюторами брендов Nike, Adidas, Puma и Reebok.</p>
            </div>
            
            <div class="card" style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 16px; color: var(--accent-blue);">⚡</div>
                <h3 style="margin-bottom: 12px;">Быстрая доставка</h3>
                <p style="color: var(--text-secondary); font-size: 14px;">Отправка заказов в течение 24 часов. Бесплатная примерка перед покупкой в пунктах выдачи.</p>
            </div>
            
            <div class="card" style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 16px; color: #a855f7;">💎</div>
                <h3 style="margin-bottom: 12px;">Премиум сервис</h3>
                <p style="color: var(--text-secondary); font-size: 14px;">Персональная консультация по подбору размеров и технологичных тканей для ваших целей.</p>
            </div>
        </div>
    </div>

    <!-- Featured Products / New Arrivals -->
    <div style="margin-bottom: 64px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <h2 style="font-size: 28px; margin: 0;">Популярные товары</h2>
            <a href="{{ route('catalog.index') }}" style="color: var(--accent-blue); font-size: 14px; font-weight: 600;">Все товары &rarr;</a>
        </div>

        <div class="grid-4">
            @foreach($featuredProducts as $product)
                <div class="card product-card">
                    <a href="{{ route('catalog.show', $product->slug) }}" class="product-image-container">
                        @if($product->image_path)
                            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="product-image-placeholder">👟</div>
                        @endif
                        
                        @if($product->promo_price !== null)
                            @php
                                $discount = round((($product->price - $product->promo_price) / $product->price) * 100);
                            @endphp
                            <span class="product-badge-sale">-{{ $discount }}%</span>
                        @endif
                    </a>

                    <span class="product-brand">{{ $product->brand }}</span>
                    <h3 class="product-title">
                        <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    
                    <div class="product-price-row">
                        @if($product->promo_price !== null)
                            <span class="product-price" style="color: var(--accent-emerald);">{{ number_format($product->promo_price, 0, '.', ' ') }} ₽</span>
                            <span class="product-price-old">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                        @else
                            <span class="product-price">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                        @endif
                    </div>

                    <div style="margin-top: auto; display: flex; gap: 8px;">
                        <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-secondary btn-sm" style="flex: 1;">Детали</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- About Section -->
    <div class="card" style="background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg-secondary) 100%); padding: 40px; display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px; align-items: center;">
        <div>
            <h2 style="font-size: 28px; margin-bottom: 16px;">Наша миссия и цели</h2>
            <p style="color: var(--text-secondary); margin-bottom: 20px; font-size: 15px;">Мы верим, что качественная спортивная одежда — это не просто гардероб, а важный катализатор ваших побед. В Velocity мы стремимся обеспечить каждого спортсмена, любителя и профессионала, лучшей экипировкой, разработанной с учетом новейших технологических исследований в области терморегуляции и влагоотведения.</p>
            <p style="color: var(--text-secondary); font-size: 15px;">Наши консультанты всегда на связи, чтобы подобрать вещи, идеально соответствующие вашему стилю тренировок и анатомическим особенностям.</p>
        </div>
        <div style="background: var(--bg-input); border-radius: var(--radius-md); padding: 30px; border: 1px solid var(--border-color); text-align: center;">
            <div style="font-size: 48px; font-weight: 800; color: var(--accent-emerald); margin-bottom: 8px;">10 000+</div>
            <p style="color: var(--text-primary); font-weight: 600; margin-bottom: 24px;">довольных клиентов по всей стране</p>
            
            <div style="display: flex; justify-content: space-around; gap: 16px;">
                <div>
                    <div style="font-size: 24px; font-weight: 700; color: white;">24/7</div>
                    <span style="font-size: 12px; color: var(--text-secondary);">поддержка</span>
                </div>
                <div>
                    <div style="font-size: 24px; font-weight: 700; color: white;">500+</div>
                    <span style="font-size: 12px; color: var(--text-secondary);">моделей</span>
                </div>
            </div>
        </div>
    </div>
@endsection
