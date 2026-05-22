@extends('layouts.app')

@section('title', 'Каталог спортивной одежды и обуви | Velocity')
@section('meta_description', 'Широкий ассортимент оригинальной спортивной одежды и обуви. Удобная фильтрация по размеру, бренду, цене. Быстрая доставка по России.')

@section('content')
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 36px; margin-bottom: 8px;">Каталог товаров</h1>
        <p style="color: var(--text-secondary);">Найдите идеальную экипировку для ваших тренировок и повседневной активности.</p>
    </div>

    <div class="catalog-layout">
        <!-- Sidebar Filters -->
        <aside class="catalog-sidebar">
            <form action="{{ route('catalog.index') }}" method="GET" id="catalog-filter-form">
                <!-- Keep active category if set -->
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                
                <!-- Category list navigation -->
                <div class="filter-section">
                    <h3 class="filter-title">Категории</h3>
                    <ul class="filter-list">
                        <li style="margin-bottom: 8px;">
                            <a href="{{ route('catalog.index', request()->except('category')) }}" 
                               style="font-size: 14px; font-weight: {{ !request('category') ? '700' : '500' }}; color: {{ !request('category') ? 'var(--accent-emerald)' : 'var(--text-secondary)' }};">
                                Все категории
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li style="margin-bottom: 8px;">
                                <a href="{{ route('catalog.index', array_merge(request()->all(), ['category' => $cat->slug])) }}" 
                                   style="font-size: 14px; font-weight: {{ request('category') == $cat->slug ? '700' : '500' }}; color: {{ request('category') == $cat->slug ? 'var(--accent-emerald)' : 'var(--text-secondary)' }};">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Brand filter -->
                <div class="filter-section">
                    <h3 class="filter-title">Бренды</h3>
                    <ul class="filter-list">
                        @foreach($brands as $b)
                            <li class="filter-item">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; width: 100%;">
                                    <input type="checkbox" name="brands[]" value="{{ $b }}" 
                                           {{ in_array($b, request('brands', [])) ? 'checked' : '' }}
                                           onchange="document.getElementById('catalog-filter-form').submit();">
                                    {{ $b }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Size filter -->
                <div class="filter-section">
                    <h3 class="filter-title">Размеры</h3>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                        @foreach($availableSizes as $sz)
                            <label style="display: flex; align-items: center; justify-content: center; gap: 4px; padding: 6px 4px; background: var(--bg-input); border: 1px solid {{ in_array($sz, request('sizes', [])) ? 'var(--accent-emerald)' : 'var(--border-color)' }}; border-radius: 4px; font-size: 12px; font-weight: 600; color: {{ in_array($sz, request('sizes', [])) ? 'var(--accent-emerald)' : 'var(--text-secondary)' }}; cursor: pointer;">
                                <input type="checkbox" name="sizes[]" value="{{ $sz }}" 
                                       {{ in_array($sz, request('sizes', [])) ? 'checked' : '' }}
                                       style="display: none;"
                                       onchange="document.getElementById('catalog-filter-form').submit();">
                                {{ $sz }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price filter -->
                <div class="filter-section">
                    <h3 class="filter-title">Цена (₽)</h3>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <input type="number" name="price_min" class="form-control" placeholder="Мин" value="{{ request('price_min') }}" style="padding: 8px;" min="0">
                        <span style="color: var(--text-secondary);">—</span>
                        <input type="number" name="price_max" class="form-control" placeholder="Макс" value="{{ request('price_max') }}" style="padding: 8px;" min="0">
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm" style="width: 100%; margin-top: 12px; justify-content: center;">Применить цены</button>
                </div>

                <a href="{{ route('catalog.index') }}" class="btn btn-danger btn-sm" style="width: 100%; margin-top: 16px; justify-content: center;">Сбросить все фильтры</a>
            </form>
        </aside>

        <!-- Product Grid & Sorting -->
        <div>
            <!-- Sort and Total stats -->
            <div style="display: flex; align-items: center; justify-content: space-between; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 12px 20px; margin-bottom: 24px;">
                <span style="font-size: 14px; color: var(--text-secondary);">
                    Найдено товаров: <strong style="color: white;">{{ $products->total() }}</strong>
                </span>

                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 14px; color: var(--text-secondary);">Сортировка:</span>
                    <select name="sort" class="form-control" style="padding: 6px 12px; width: 180px;" onchange="const url = new URL(window.location.href); url.searchParams.set('sort', this.value); window.location.href = url.href;">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Новинки</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Сначала дешевые</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Сначала дорогие</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid-3" style="margin-bottom: 40px;">
                @forelse($products as $product)
                    <div class="card product-card">
                        <!-- Image Container -->
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

                        <!-- Brand and Category -->
                        <span class="product-brand">{{ $product->brand }}</span>
                        
                        <!-- Title -->
                        <h3 class="product-title">
                            <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>

                        <!-- Available sizes info -->
                        <div style="margin-bottom: 12px;">
                            <span style="font-size: 11px; color: var(--text-secondary); display: block; margin-bottom: 4px;">Размеры:</span>
                            <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                @foreach(explode(',', $product->sizes) as $sz)
                                    <span style="font-size: 10px; font-weight: 700; padding: 2px 6px; background: var(--bg-input); border: 1px solid var(--border-color); border-radius: 4px; color: white;">
                                        {{ trim($sz) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price and Stock -->
                        <div class="product-price-row" style="margin-top: auto; margin-bottom: 16px;">
                            @if($product->promo_price !== null)
                                <span class="product-price" style="color: var(--accent-emerald);">{{ number_format($product->promo_price, 0, '.', ' ') }} ₽</span>
                                <span class="product-price-old">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                            @else
                                <span class="product-price">{{ number_format($product->price, 0, '.', ' ') }} ₽</span>
                            @endif
                            
                            @if($product->stock === 0)
                                <span style="font-size: 11px; color: #ef4444; margin-left: auto; font-weight: 600;">Нет в наличии</span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div>
                            <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-secondary btn-sm" style="width: 100%; justify-content: center;">
                                Подробнее
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 64px;">
                        <span style="font-size: 64px;">🔍</span>
                        <h3 style="margin-top: 16px; margin-bottom: 8px;">Товары не найдены</h3>
                        <p style="color: var(--text-secondary); max-width: 420px; margin: 0 auto;">К сожалению, ни один товар не соответствует выбранным критериям фильтрации.</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="margin-top: 24px;">Сбросить все фильтры</a>
                    </div>
                @endforelse
            </div>

            <!-- Custom Pagination styling -->
            <div class="custom-pagination" style="display: flex; justify-content: center; gap: 8px;">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
