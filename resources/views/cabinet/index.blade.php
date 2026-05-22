@extends('layouts.app')

@section('title', 'Личный кабинет | Velocity Sport')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Личный кабинет</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Управляйте своим профилем, адресами и отслеживайте заказы.</p>
        </div>
        @if($user->isAdmin())
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
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <h3 style="margin: 0; color: white; font-size: 16px; font-weight: 600;">{{ $user->name }}</h3>
                <span style="font-size: 12px; color: var(--text-secondary);">{{ $user->email }}</span>
            </div>

            <a href="{{ route('cabinet.index') }}" class="btn" style="justify-content: flex-start; background: var(--accent-blue); color: white; width: 100%;">
                👤 Личные данные
            </a>
            <a href="{{ route('cabinet.addresses') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                📍 Адреса доставки
            </a>
            <a href="{{ route('cabinet.orders') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
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
                <span>👤</span> Личные данные профиля
            </h2>

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

            <form action="{{ route('cabinet.profile.update') }}" method="POST">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="name">Ваше имя</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="email">E-mail адрес</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 28px;">
                    <label class="form-label" for="phone">Номер телефона</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="+7 (999) 123-45-67" value="{{ old('phone', $user->phone) }}">
                </div>

                <div style="border-top: 1px solid var(--border-color); padding-top: 24px; margin-bottom: 20px;">
                    <h3 style="font-size: 15px; color: white; margin-bottom: 4px; font-weight: 600;">Безопасность</h3>
                    <p style="color: var(--text-secondary); font-size: 12px; margin-top: 0; margin-bottom: 16px;">Заполните поля ниже, только если хотите изменить текущий пароль.</p>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="password">Новый пароль</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Мин. 6 символов">
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="password_confirmation">Подтверждение нового пароля</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 32px;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px;">
                        💾 Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="display: grid; grid-template-columns: 280px 1fr"] {
            grid-template-columns: 1fr !important;
        }
        div[style*="display: grid; grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
