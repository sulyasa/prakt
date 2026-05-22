@extends('layouts.app')

@section('title', 'Настройки сайта | Панель управления')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Настройки сайта</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Редактирование контактных и служебных данных интернет-магазина.</p>
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
                📊 Главная panel
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
            <a href="{{ route('admin.reviews') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                💬 Модерация отзывов
            </a>
            <a href="{{ route('admin.settings') }}" class="btn" style="justify-content: var(--accent-blue); background: var(--accent-blue); color: white; width: 100%;">
                ⚙️ Настройки сайта
            </a>
        </div>

        <!-- Main Settings Content -->
        <div class="card" style="padding: 40px; background: var(--bg-card);">
            <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <span>⚙️</span> Контактные и служебные данные
            </h2>
            <p style="color: var(--text-secondary); font-size: 13px; margin-top: 0; margin-bottom: 32px;">Эти параметры используются по всему сайту для отображения контактов и работы формы обратного звонка.</p>

            @if(session('success'))
                <div class="alert alert-success" style="padding: 12px 16px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" style="padding: 12px 16px; margin-bottom: 24px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    @foreach($settings as $setting)
                        @php
                            $label = $setting->key;
                            $placeholder = '';
                            $inputType = 'text';
                            
                            switch($setting->key) {
                                case 'manager_phone':
                                    $label = '📞 Номер телефона менеджера (для кнопки обратного вызова)';
                                    $placeholder = '+7 (999) 123-45-67';
                                    break;
                                case 'shop_address':
                                    $label = '📍 Физический адрес магазина';
                                    $placeholder = 'г. Москва, ул. Спортивная, д. 15';
                                    $inputType = 'textarea';
                                    break;
                                case 'shop_email':
                                    $label = '📧 E-mail адрес магазина';
                                    $placeholder = 'info@sportshop.ru';
                                    $inputType = 'email';
                                    break;
                                case 'shop_hours':
                                    $label = '⏰ Режим работы магазина';
                                    $placeholder = 'Ежедневно: с 09:00 до 21:00';
                                    break;
                            }
                        @endphp
                        
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="setting-{{ $setting->id }}" style="font-weight: 700; color: white;">
                                {{ $label }}
                            </label>
                            
                            @if($inputType === 'textarea')
                                <textarea name="settings[{{ $setting->id }}]" id="setting-{{ $setting->id }}" class="form-control" rows="3" required placeholder="{{ $placeholder }}">{{ $setting->value }}</textarea>
                            @else
                                <input type="{{ $inputType }}" name="settings[{{ $setting->id }}]" id="setting-{{ $setting->id }}" class="form-control" value="{{ $setting->value }}" required placeholder="{{ $placeholder }}">
                            @endif
                        </div>
                    @endforeach
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px;">
                        💾 Сохранить все настройки
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @media (max-width: 992px) {
        div[style*="display: grid; grid-template-columns: 280px 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
