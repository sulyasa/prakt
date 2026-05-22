@extends('layouts.app')

@section('title', 'Управление категориями | Панель управления')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Управление категориями</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Создание, редактирование и удаление категорий товаров.</p>
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
            <a href="{{ route('admin.categories') }}" class="btn" style="justify-content: flex-start; background: var(--accent-blue); color: white; width: 100%;">
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
            <a href="{{ route('admin.settings') }}" class="btn" style="justify-content: flex-start; background: transparent; color: white; border: 1px solid var(--border-color); width: 100%; transition: all 0.2s ease;" onmouseover="this.style.background='var(--bg-input)'" onmouseout="this.style.background='transparent'">
                ⚙️ Настройки сайта
            </a>
        </div>

        <!-- Main Categories Content -->
        <div style="display: flex; flex-direction: column; gap: 32px;">
            @if(session('success'))
                <div class="alert alert-success" style="padding: 12px 16px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" style="padding: 12px 16px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start;">
                <!-- Existing Categories -->
                <div class="card" style="padding: 40px; background: var(--bg-card);">
                    <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                        <span>📁</span> Список категорий
                    </h2>

                    @if($categories->isEmpty())
                        <p style="color: var(--text-secondary); text-align: center;">Категории пока не созданы.</p>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            @foreach($categories as $cat)
                                <div style="background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 12px;">
                                        <div>
                                            <h3 style="margin: 0; color: white; font-size: 16px; font-weight: 700;">{{ $cat->name }}</h3>
                                            <span style="font-size: 12px; color: var(--text-secondary);">Товаров в категории: {{ $cat->products_count }}</span>
                                        </div>
                                        
                                        <div style="display: flex; gap: 8px;">
                                            <button onclick="toggleEditForm({{ $cat->id }})" class="btn" style="background: rgba(59, 130, 246, 0.1); color: var(--accent-blue); border: 1px solid rgba(59, 130, 246, 0.2); padding: 6px 12px; font-size: 12px;">
                                                ✏️ Изменить
                                            </button>
                                            
                                            <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Внимание! При удалении категории будут удалены ВСЕ связанные с ней товары! Вы уверены?')">
                                                @csrf
                                                <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 6px 12px; font-size: 12px;">
                                                    🗑️ Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    @if($cat->description)
                                        <p style="margin: 0 0 12px 0; color: var(--text-secondary); font-size: 13px; line-height: 1.4;">
                                            {{ $cat->description }}
                                        </p>
                                    @endif

                                    <!-- Edit form toggled by JS -->
                                    <div id="edit-form-{{ $cat->id }}" style="display: none; border-top: 1px dashed var(--border-color); padding-top: 16px; margin-top: 12px;">
                                        <h4 style="color: white; margin: 0 0 12px 0; font-size: 14px;">Редактирование категории</h4>
                                        <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label" style="font-size: 11px;">Название категории</label>
                                                <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" style="font-size: 11px;">Описание</label>
                                                <textarea name="description" class="form-control" rows="2" style="font-size: 13px;">{{ $cat->description }}</textarea>
                                            </div>
                                            <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 12px;">
                                                <button type="button" onclick="toggleEditForm({{ $cat->id }})" class="btn" style="background: var(--bg-card); border: 1px solid var(--border-color); color: white; padding: 6px 12px; font-size: 12px;">
                                                    Отмена
                                                </button>
                                                <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">
                                                    💾 Обновить
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Create Category Form -->
                <div class="card" style="padding: 40px; background: var(--bg-card);">
                    <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                        <span>➕</span> Создать категорию
                    </h2>

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label" for="name">Название категории</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Например: Ветровки" required>
                        </div>

                        <div class="form-group" style="margin-bottom: 24px;">
                            <label class="form-label" for="description">Описание категории (необязательно)</label>
                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Краткое описание товаров в этой категории..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">
                            ➕ Создать категорию
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleEditForm(id) {
        const form = document.getElementById('edit-form-' + id);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>

<style>
    @media (max-width: 992px) {
        div[style*="display: grid; grid-template-columns: 280px 1fr"] {
            grid-template-columns: 1fr !important;
        }
        div[style*="display: grid; grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
