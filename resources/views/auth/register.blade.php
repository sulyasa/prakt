@extends('layouts.app')

@section('title', 'Регистрация | Velocity Sport')

@section('content')
    <div style="max-width: 450px; margin: 0 auto; margin-top: 40px; margin-bottom: 64px;">
        <div class="card" style="padding: 40px; background: var(--bg-card);">
            <div style="text-align: center; margin-bottom: 32px;">
                <span style="font-size: 48px;">📝</span>
                <h1 style="font-size: 28px; margin-top: 16px; font-family: var(--font-heading); color: white;">Регистрация</h1>
                <p style="color: var(--text-secondary); font-size: 13px; margin-top: 4px;">Присоединяйтесь к нам, чтобы совершать выгодные покупки и управлять заказами!</p>
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

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="name">Ваше имя</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Иван Иванов" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">E-mail адрес</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="example@sportshop.ru" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">Номер телефона</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="+7 (999) 123-45-67" value="{{ old('phone') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Пароль (мин. 6 символов)</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" for="password_confirmation">Подтверждение пароля</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px; font-size: 15px;">
                    Зарегистрироваться
                </button>
            </form>

            <div style="text-align: center; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
                <span style="font-size: 13px; color: var(--text-secondary);">Уже зарегистрированы?</span>
                <a href="{{ route('login') }}" style="display: block; font-size: 14px; font-weight: 700; color: var(--accent-blue); margin-top: 6px;">
                    Войти в существующий аккаунт &rarr;
                </a>
            </div>
        </div>
    </div>
@endsection
