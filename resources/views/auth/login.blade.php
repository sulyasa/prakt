@extends('layouts.app')

@section('title', 'Авторизация | Velocity Sport')

@section('content')
    <div style="max-width: 450px; margin: 0 auto; margin-top: 40px; margin-bottom: 64px;">
        <div class="card" style="padding: 40px; background: var(--bg-card);">
            <div style="text-align: center; margin-bottom: 32px;">
                <span style="font-size: 48px;">🔑</span>
                <h1 style="font-size: 28px; margin-top: 16px; font-family: var(--font-heading); color: white;">Вход в аккаунт</h1>
                <p style="color: var(--text-secondary); font-size: 13px; margin-top: 4px;">С возвращением! Авторизуйтесь, чтобы продолжить покупки.</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-error" style="padding: 12px 16px; margin-bottom: 20px;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="email">E-mail адрес</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="example@sportshop.ru" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group" style="margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                        <label class="form-label" for="password" style="margin-bottom: 0;">Пароль</label>
                    </div>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; color: var(--text-secondary);">
                        <input type="checkbox" name="remember" style="accent-color: var(--accent-emerald); width: 16px; height: 16px;">
                        Запомнить меня на этом устройстве
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px; font-size: 15px;">
                    Войти в личный кабинет
                </button>
            </form>

            <div style="text-align: center; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
                <span style="font-size: 13px; color: var(--text-secondary);">Еще нет аккаунта?</span>
                <a href="{{ route('register') }}" style="display: block; font-size: 14px; font-weight: 700; color: var(--accent-blue); margin-top: 6px;">
                    Создать новый аккаунт &rarr;
                </a>
            </div>
            
            <div style="background: var(--bg-input); border-radius: var(--radius-sm); border: 1px solid var(--border-color); padding: 12px; margin-top: 20px; font-size: 11px; text-align: center; color: var(--text-secondary);">
                💡 <strong>Тестовые аккаунты для входа:</strong><br>
                Клиент: <code>user@sportshop.ru</code> / пароль: <code>user123</code><br>
                Админ: <code>admin@sportshop.ru</code> / пароль: <code>admin123</code>
            </div>
        </div>
    </div>
@endsection
