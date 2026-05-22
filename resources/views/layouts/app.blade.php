<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Магазин спортивной одежды | Топовые мировые бренды')</title>
    <meta name="description" content="@yield('meta_description', 'Современный интернет-магазин спортивной одежды и обуви от ведущих мировых брендов. Высокое качество, быстрая доставка, выгодные цены!')">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Open Graph (Social SEO) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Магазин спортивной одежды | Топовые мировые бренды')">
    <meta property="og:description" content="@yield('meta_description', 'Современный интернет-магазин спортивной одежды и обуви от ведущих брендов.')">
    <meta property="og:url" content="{{ request()->url() }}">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Schema.org Microdata for Local Business -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SportsStore",
      "name": "⚡ Velocity Sport",
      "image": "https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=600",
      "telephone": "{{ \App\Models\Setting::get('manager_phone', '+7 (999) 123-45-67') }}",
      "email": "{{ \App\Models\Setting::get('shop_email', 'info@sportshop.ru') }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ \App\Models\Setting::get('shop_address', 'г. Москва, ул. Спортивная, д. 42') }}",
        "addressLocality": "Москва",
        "addressCountry": "RU"
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
          "Sunday"
        ],
        "opens": "10:00",
        "closes": "22:00"
      }
    }
    </script>
    
    @yield('extra_head')
</head>
<body>
    <div class="app-container">
        <!-- Premium Header -->
        <header>
            <div class="header-container">
                <div class="logo">
                    <a href="{{ route('home') }}">VELOCITY</a>
                </div>
                
                <nav class="main-nav">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">О нас</a>
                    <a href="{{ route('catalog.index') }}" class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">Каталог</a>
                    <a href="{{ route('promotions.index') }}" class="nav-link {{ request()->routeIs('promotions.*') ? 'active' : '' }}">Акции</a>
                    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">Полезные статьи</a>
                    <a href="{{ route('reviews.index') }}" class="nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">Отзывы</a>
                    <a href="{{ route('contacts') }}" class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}">Контакты</a>
                </nav>
                
                <div class="header-actions">
                    <!-- Shopping Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="cart-icon-wrapper" title="Корзина" id="cart-nav-btn">
                        <span>🛒</span>
                        @php
                            $cartCount = 0;
                            $cart = session()->get('cart', []);
                            foreach ($cart as $item) {
                                $cartCount += $item['quantity'];
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="cart-badge" id="cart-badge-count">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    <!-- Auth Actions -->
                    @auth
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <a href="{{ route('cabinet.index') }}" class="user-menu-trigger">
                                <span>👤</span> {{ Auth::user()->name }}
                            </a>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm" style="background: rgba(59, 130, 246, 0.2); border-color: rgba(59, 130, 246, 0.4);">
                                    Админ
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 6px 10px; font-size: 12px; border-radius: 4px;" title="Выйти">
                                    🚪
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">Войти</a>
                        <a href="{{ route('register') }}" class="btn-register">Регистрация</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Floating pulsing "Call Manager" button -->
        @php
            $managerPhone = \App\Models\Setting::get('manager_phone', '+7 (999) 123-45-67');
            $cleanPhone = preg_replace('/[^0-9+]/', '', $managerPhone);
        @endphp
        <a href="tel:{{ $cleanPhone }}" class="call-manager-btn" title="Позвонить менеджеру" id="floating-call-btn">
            📞
        </a>

        <!-- Global Footer -->
        <footer>
            <div class="footer-container">
                <div class="footer-about">
                    <div class="logo" style="margin-bottom: 16px;">
                        <a href="{{ route('home') }}">VELOCITY</a>
                    </div>
                    <p>Современный интернет-магазин оригинальной спортивной одежды и обуви. Помогаем достигать новых спортивных высот в максимальном комфорте.</p>
                </div>
                
                <div class="footer-links">
                    <h4>Навигация</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">О нас</a></li>
                        <li><a href="{{ route('catalog.index') }}">Каталог товаров</a></li>
                        <li><a href="{{ route('promotions.index') }}">Текущие акции</a></li>
                        <li><a href="{{ route('articles.index') }}">Блог и статьи</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4>Поддержка</h4>
                    <ul>
                        <li><a href="{{ route('reviews.index') }}">Отзывы о магазине</a></li>
                        <li><a href="{{ route('contacts') }}">Контакты и карта</a></li>
                        <li><a href="{{ route('cabinet.index') }}">Личный кабинет</a></li>
                        @guest
                            <li><a href="{{ route('login') }}">Вход / Регистрация</a></li>
                        @endguest
                    </ul>
                </div>

                <div class="footer-contact">
                    <h4>Контакты</h4>
                    <p>📍 <strong>Адрес:</strong> {{ \App\Models\Setting::get('shop_address', 'г. Москва, ул. Спортивная, д. 42') }}</p>
                    <p>📞 <strong>Телефон:</strong> {{ $managerPhone }}</p>
                    <p>✉️ <strong>Email:</strong> {{ \App\Models\Setting::get('shop_email', 'info@sportshop.ru') }}</p>
                    <p>🕒 <strong>Режим работы:</strong> {{ \App\Models\Setting::get('shop_hours', 'Пн-Вс: 10:00 - 22:00') }}</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('y') == '26' ? '2026' : '2026-' . date('Y') }} Velocity Sport Shop. Все права защищены.</p>
                <p>Разработка в рамках учебной практики • Стек Laravel & SQLite</p>
            </div>
        </footer>
    </div>
    
    @yield('extra_scripts')
</body>
</html>
