@extends('layouts.app')

@section('title', 'Адреса доставки | Velocity Sport')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Личный кабинет</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Управляйте своими адресами доставки для быстрого оформления заказов.</p>
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
            <a href="{{ route('cabinet.addresses') }}" class="btn" style="justify-content: flex-start; background: var(--accent-blue); color: white; width: 100%;">
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
        <div style="display: flex; flex-direction: column; gap: 32px;">
            <!-- Existing Addresses -->
            <div class="card" style="padding: 40px; background: var(--bg-card);">
                <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                    <span>📍</span> Сохраненные адреса
                </h2>

                @if(session('success'))
                    <div class="alert alert-success" style="padding: 12px 16px; margin-bottom: 24px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($addresses->isEmpty())
                    <div style="text-align: center; padding: 40px 20px; color: var(--text-secondary);">
                        <span style="font-size: 40px; display: block; margin-bottom: 12px;">🗺️</span>
                        У вас пока нет сохраненных адресов доставки. Добавьте ваш первый адрес ниже!
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        @foreach($addresses as $addr)
                            <div style="background: var(--bg-input); border: 1px solid {{ $addr->is_default ? 'var(--accent-emerald)' : 'var(--border-color)' }}; border-radius: var(--radius-md); padding: 20px; display: flex; justify-content: space-between; align-items: center; gap: 20px;">
                                <div style="display: flex; gap: 16px; align-items: flex-start;">
                                    <span style="font-size: 20px; margin-top: 2px;">📍</span>
                                    <div>
                                        <p style="margin: 0; color: white; line-height: 1.5; font-size: 15px;">{{ $addr->address }}</p>
                                        @if($addr->is_default)
                                            <span style="display: inline-block; background: rgba(16, 185, 129, 0.1); color: var(--accent-emerald); border: 1px solid rgba(16, 185, 129, 0.2); font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 12px; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                По умолчанию
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <form action="{{ route('cabinet.addresses.delete', $addr->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот адрес?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 8px 12px; font-size: 13px;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                                        🗑️ Удалить
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Add Address Form -->
            <div class="card" style="padding: 40px; background: var(--bg-card);">
                <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                    <span>➕</span> Добавить новый адрес
                </h2>
                <p style="color: var(--text-secondary); font-size: 13px; margin-top: 0; margin-bottom: 24px;">Введите адрес доставки полностью (город, улица, дом, квартира, почтовый индекс).</p>

                <form action="{{ route('cabinet.addresses.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="address">Адрес доставки</label>
                        <textarea name="address" id="address" class="form-control" rows="3" placeholder="г. Москва, ул. Спортивная, д. 10, кв. 42" required style="resize: vertical; min-height: 80px;"></textarea>
                    </div>

                    @if(!$addresses->isEmpty())
                        <div class="form-group" style="margin-bottom: 24px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; color: var(--text-secondary);">
                                <input type="checkbox" name="is_default" value="1" style="accent-color: var(--accent-emerald); width: 16px; height: 16px;">
                                Сделать этот адрес основным (по умолчанию)
                            </label>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary" style="padding: 12px 28px;">
                            ➕ Сохранить адрес
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="display: grid; grid-template-columns: 280px 1fr"] {
            grid-template-columns: 1fr !important;
        }
        div[style*="padding: 20px; display: flex; justify-content: space-between; align-items: center"] {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        form[action*="addresses.delete"] {
            width: 100%;
        }
        form[action*="addresses.delete"] button {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
