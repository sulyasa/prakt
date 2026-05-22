@extends('layouts.app')

@section('title', 'Управление товарами | Панель управления')

@section('content')
<div style="margin-bottom: 64px; margin-top: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 32px; font-family: var(--font-heading); color: white; margin: 0;">Управление товарами</h1>
            <p style="color: var(--text-secondary); margin-top: 4px; margin-bottom: 0;">Добавление, редактирование и удаление спортивной одежды.</p>
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
            <a href="{{ route('admin.products') }}" class="btn" style="justify-content: flex-start; background: var(--accent-blue); color: white; width: 100%;">
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

        <!-- Main Products Content -->
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

            <!-- Add Product Section -->
            <div class="card" style="padding: 40px; background: var(--bg-card);">
                <button onclick="toggleAddForm()" class="btn btn-primary" style="display: flex; gap: 8px; margin-bottom: 0;">
                    ➕ Добавить новый товар
                </button>

                <div id="add-product-form" style="display: none; border-top: 1px solid var(--border-color); margin-top: 24px; padding-top: 24px;">
                    <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px;">📝 Новый товар</h2>
                    
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="name">Название товара</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Например: Спортивный костюм Nike" required>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="category_id">Категория</label>
                                <select name="category_id" id="category_id" class="form-control" required style="background: var(--bg-input); color: white; border: 1px solid var(--border-color);">
                                    <option value="">Выберите категорию...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="brand">Бренд</label>
                                <input type="text" name="brand" id="brand" class="form-control" placeholder="Например: Nike" required>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="sizes">Доступные размеры (через запятую)</label>
                                <input type="text" name="sizes" id="sizes" class="form-control" placeholder="Например: S, M, L, XL" required>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="price">Цена (руб.)</label>
                                <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="5990" required>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="promo_price">Акционная цена (необязательно)</label>
                                <input type="number" step="0.01" name="promo_price" id="promo_price" class="form-control" placeholder="4990">
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="stock">Количество на складе</label>
                                <input type="number" name="stock" id="stock" class="form-control" placeholder="10" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="description">Описание товара</label>
                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Введите детальное описание товара..." required></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 24px;">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="image">Изображение товара</label>
                                <input type="file" name="image" id="image" class="form-control" style="padding: 8px;">
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; color: white;">
                                    <input type="checkbox" name="is_active" value="1" checked style="accent-color: var(--accent-emerald); width: 18px; height: 18px;">
                                    Опубликован (виден на сайте)
                                </label>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 12px;">
                            <button type="button" onclick="toggleAddForm()" class="btn" style="background: var(--bg-input); border: 1px solid var(--border-color); color: white;">
                                Отмена
                            </button>
                            <button type="submit" class="btn btn-primary" style="padding: 12px 24px;">
                                ➕ Добавить товар
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products List -->
            <div class="card" style="padding: 40px; background: var(--bg-card);">
                <h2 style="font-size: 20px; font-family: var(--font-heading); color: white; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                    <span>👕</span> Список всех товаров ({{ $products->count() }})
                </h2>

                @if($products->isEmpty())
                    <p style="color: var(--text-secondary); text-align: center;">В базе данных пока нет товаров.</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        @foreach($products as $prod)
                            <div style="background: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
                                    <!-- Image and details -->
                                    <div style="display: flex; align-items: center; gap: 16px; flex: 1; min-width: 250px;">
                                        <div style="width: 64px; height: 64px; background: var(--bg-card); border-radius: var(--radius-sm); border: 1px solid var(--border-color); overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                            @if($prod->image_path && file_exists(public_path($prod->image_path)))
                                                <img src="{{ asset($prod->image_path) }}" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                👕
                                            @endif
                                        </div>
                                        <div>
                                            <h3 style="margin: 0; color: white; font-size: 16px; font-weight: 700;">
                                                {{ $prod->name }}
                                                @if(!$prod->is_active)
                                                    <span style="font-size: 10px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 1px 6px; border-radius: 8px; margin-left: 6px; vertical-align: middle;">Черновик</span>
                                                @endif
                                            </h3>
                                            <span style="font-size: 12px; color: var(--text-secondary);">
                                                Категория: <strong style="color: white;">{{ $prod->category->name ?? 'Без категории' }}</strong> | Бренд: <strong style="color: white;">{{ $prod->brand }}</strong> | Размеры: <strong style="color: white;">{{ $prod->sizes }}</strong>
                                            </span>
                                            <div style="margin-top: 4px; font-size: 13px;">
                                                Наличие: <strong style="color: {{ $prod->stock > 0 ? 'var(--accent-emerald)' : '#ef4444' }};">{{ $prod->stock }} шт.</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price and actions -->
                                    <div style="text-align: right; display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
                                        <div>
                                            @if($prod->promo_price)
                                                <span style="text-decoration: line-through; color: var(--text-secondary); font-size: 12px; display: block;">{{ number_format($prod->price, 0, '.', ' ') }} ₽</span>
                                                <span style="color: var(--accent-emerald); font-weight: 800; font-size: 16px;">{{ number_format($prod->promo_price, 0, '.', ' ') }} ₽</span>
                                            @else
                                                <span style="color: white; font-weight: 700; font-size: 16px;">{{ number_format($prod->price, 0, '.', ' ') }} ₽</span>
                                            @endif
                                        </div>

                                        <div style="display: flex; gap: 8px;">
                                            <button onclick="toggleEditForm({{ $prod->id }})" class="btn" style="background: rgba(59, 130, 246, 0.1); color: var(--accent-blue); border: 1px solid rgba(59, 130, 246, 0.2); padding: 8px 12px; font-size: 13px;">
                                                ✏️ Изменить
                                            </button>
                                            
                                            <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить товар?')">
                                                @csrf
                                                <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 8px 12px; font-size: 13px;">
                                                    🗑️ Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit form toggled by JS -->
                                <div id="edit-form-{{ $prod->id }}" style="display: none; border-top: 1px dashed var(--border-color); padding-top: 20px; margin-top: 20px;">
                                    <h4 style="color: white; margin: 0 0 16px 0; font-size: 15px; font-weight: 700;">Редактирование товара</h4>
                                    
                                    <form action="{{ route('admin.products.update', $prod->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label class="form-label" style="font-size: 12px;">Название товара</label>
                                                <input type="text" name="name" class="form-control" value="{{ $prod->name }}" required>
                                            </div>

                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label class="form-label" style="font-size: 12px;">Категория</label>
                                                <select name="category_id" class="form-control" required style="background: var(--bg-input); color: white; border: 1px solid var(--border-color);">
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $prod->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label class="form-label" style="font-size: 12px;">Бренд</label>
                                                <input type="text" name="brand" class="form-control" value="{{ $prod->brand }}" required>
                                            </div>

                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label class="form-label" style="font-size: 12px;">Доступные размеры (через запятую)</label>
                                                <input type="text" name="sizes" class="form-control" value="{{ $prod->sizes }}" required>
                                            </div>
                                        </div>

                                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label class="form-label" style="font-size: 12px;">Цена (руб.)</label>
                                                <input type="number" step="0.01" name="price" class="form-control" value="{{ $prod->price }}" required>
                                            </div>

                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label class="form-label" style="font-size: 12px;">Акционная цена (необязательно)</label>
                                                <input type="number" step="0.01" name="promo_price" class="form-control" value="{{ $prod->promo_price }}">
                                            </div>

                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label class="form-label" style="font-size: 12px;">Количество на складе</label>
                                                <input type="number" name="stock" class="form-control" value="{{ $prod->stock }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" style="font-size: 12px;">Описание товара</label>
                                            <textarea name="description" class="form-control" rows="4" required>{{ $prod->description }}</textarea>
                                        </div>

                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 24px;">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label class="form-label" style="font-size: 12px;">Изменить изображение</label>
                                                <input type="file" name="image" class="form-control" style="padding: 8px;">
                                            </div>

                                            <div class="form-group" style="margin-bottom: 0;">
                                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; color: white;">
                                                    <input type="checkbox" name="is_active" value="1" {{ $prod->is_active ? 'checked' : '' }} style="accent-color: var(--accent-emerald); width: 18px; height: 18px;">
                                                    Опубликован (виден на сайте)
                                                </label>
                                            </div>
                                        </div>

                                        <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                            <button type="button" onclick="toggleEditForm({{ $prod->id }})" class="btn" style="background: var(--bg-card); border: 1px solid var(--border-color); color: white;">
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
        const form = document.getElementById('add-product-form');
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
        div[style*="display: grid; grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        div[style*="display: grid; grid-template-columns: 1fr 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
