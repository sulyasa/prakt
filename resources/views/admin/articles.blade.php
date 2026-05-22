@extends('layouts.app')

@section('title', 'Управление статьями | Панель управления')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Управление статьями</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Публикация новостей, обзоров и информационных статей магазина.</p>
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
            <a href="{{ route('admin.articles') }}" class="btn" style="justify-content: var(--accent-blue); background: var(--accent-blue); color: white; width: 100%;">
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

        <!-- Main Articles Management Content -->
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

            <!-- Add Article Section -->
            <div class="card" style="padding: 40px; background: var(--bg-card);">
                <button onclick="toggleAddForm()" class="btn btn-primary" style="display: flex; gap: 8px; margin-bottom: 0;">
                    ➕ Опубликовать новую статью
                </button>

                <div id="add-article-form" style="display: none; border-top: 1px solid var(--border-color); margin-top: 24px; padding-top: 24px;">
                    <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px;">📰 Новая статья</h2>
                    
                    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label" for="title">Заголовок статьи</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Например: Как выбрать кроссовки для бега летом" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="content">Текст статьи</label>
                            <textarea name="content" id="content" class="form-control" rows="8" placeholder="Полный текст новости или статьи с разметкой..." required style="resize: vertical; min-height: 120px;"></textarea>
                        </div>

                        <div class="form-group" style="margin-bottom: 24px;">
                            <label class="form-label" for="image">Изображение для обложки</label>
                            <input type="file" name="image" id="image" class="form-control" style="padding: 8px;">
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 12px;">
                            <button type="button" onclick="toggleAddForm()" class="btn" style="background: var(--bg-input); border: 1px solid var(--border-color); color: white;">
                                Отмена
                            </button>
                            <button type="submit" class="btn btn-primary" style="padding: 12px 24px;">
                                🚀 Опубликовать статью
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Articles List -->
            <div class="card" style="padding: 40px; background: var(--bg-card);">
                <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                    <span>📰</span> Список опубликованных статей ({{ $articles->count() }})
                </h2>

                @if($articles->isEmpty())
                    <p style="color: var(--text-secondary); text-align: center;">Статьи пока не опубликованы.</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        @foreach($articles as $art)
                            <div style="background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
                                <div style="display: flex; gap: 20px; align-items: flex-start; justify-content: space-between; flex-wrap: wrap;">
                                    <div style="display: flex; gap: 16px; align-items: flex-start; flex: 1; min-width: 250px;">
                                        <div style="width: 80px; height: 80px; background: var(--bg-card); border-radius: var(--radius-sm); border: 1px solid var(--border-color); overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                                            @if($art->image_path && file_exists(public_path($art->image_path)))
                                                <img src="{{ asset($art->image_path) }}" alt="{{ $art->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                📰
                                            @endif
                                        </div>
                                        <div>
                                            <h3 style="margin: 0 0 4px 0; color: white; font-size: 16px; font-weight: 700;">{{ $art->title }}</h3>
                                            <span style="font-size: 12px; color: var(--text-secondary); display: block; margin-bottom: 8px;">
                                                Дата публикации: {{ $art->created_at->format('d.m.Y H:i') }}
                                            </span>
                                            <p style="margin: 0; color: var(--text-secondary); font-size: 13px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $art->content }}
                                            </p>
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 8px;">
                                        <button onclick="toggleEditForm({{ $art->id }})" class="btn" style="background: rgba(59, 130, 246, 0.1); color: var(--accent-blue); border: 1px solid rgba(59, 130, 246, 0.2); padding: 8px 12px; font-size: 13px;">
                                            ✏️ Изменить
                                        </button>
                                        
                                        <form action="{{ route('admin.articles.delete', $art->id) }}" method="POST" onsubmit="return confirm('Вы действительно хотите удалить эту статью?')">
                                            @csrf
                                            <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 8px 12px; font-size: 13px;">
                                                🗑️ Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit form toggled by JS -->
                                <div id="edit-form-{{ $art->id }}" style="display: none; border-top: 1px dashed var(--border-color); padding-top: 20px; margin-top: 20px;">
                                    <h4 style="color: white; margin: 0 0 16px 0; font-size: 15px; font-weight: 700;">Редактирование статьи</h4>
                                    
                                    <form action="{{ route('admin.articles.update', $art->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <label class="form-label" style="font-size: 12px;">Заголовок статьи</label>
                                            <input type="text" name="title" class="form-control" value="{{ $art->title }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" style="font-size: 12px;">Текст статьи</label>
                                            <textarea name="content" class="form-control" rows="8" required style="resize: vertical; min-height: 120px;">{{ $art->content }}</textarea>
                                        </div>

                                        <div class="form-group" style="margin-bottom: 24px;">
                                            <label class="form-label" style="font-size: 12px;">Обновить изображение обложки</label>
                                            <input type="file" name="image" class="form-control" style="padding: 8px;">
                                        </div>

                                        <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                            <button type="button" onclick="toggleEditForm({{ $art->id }})" class="btn" style="background: var(--bg-card); border: 1px solid var(--border-color); color: white;">
                                                Отмена
                                            </button>
                                            <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">
                                                💾 Сохранить изменения
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAddForm() {
        const form = document.getElementById('add-article-form');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }

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
    }
</style>
@endsection
