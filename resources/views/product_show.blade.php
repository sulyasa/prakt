@extends('layouts.app')

@section('title', $product->name . ' - Купить | Velocity Sport')
@section('meta_description', Str::limit(strip_tags($product->description), 150))

@section('extra_head')
<!-- Schema.org Product Microdata -->
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ $product->name }}",
  "image": [
    "{{ $product->image_path ? asset($product->image_path) : 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=600' }}"
  ],
  "description": "{{ strip_tags($product->description) }}",
  "sku": "prod-{{ $product->id }}",
  "brand": {
    "@type": "Brand",
    "name": "{{ $product->brand }}"
  },
  "offers": {
    "@type": "Offer",
    "url": "{{ request()->url() }}",
    "priceCurrency": "RUB",
    "price": "{{ $product->active_price }}",
    "availability": "https://schema.org/{{ $product->stock > 0 ? 'InStock' : 'OutOfStock' }}",
    "itemCondition": "https://schema.org/NewCondition"
  }
  @if($product->reviews->count() > 0)
  ,"aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $product->reviews->avg('rating') }}",
    "reviewCount": "{{ $product->reviews->count() }}"
  },
  "review": [
    @foreach($product->reviews as $index => $rev)
    {
      "@type": "Review",
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": "{{ $rev->rating }}",
        "bestRating": "5"
      },
      "author": {
        "@type": "Person",
        "name": "{{ $rev->user->name }}"
      },
      "datePublished": "{{ $rev->created_at->format('Y-m-d') }}",
      "reviewBody": "{{ strip_tags($rev->comment) }}"
    }{{ $index < $product->reviews->count() - 1 ? ',' : '' }}
    @endforeach
  ]
  @endif
}
</script>
@endsection

@section('content')
    <!-- Back to Catalog Link -->
    <a href="{{ route('catalog.index') }}" style="color: var(--accent-blue); font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 32px;">
        &larr; Назад в каталог товаров
    </a>

    <!-- Product Core Info Grid -->
    <div class="grid-2" style="margin-bottom: 64px; align-items: start;">
        <!-- Left: Product Image -->
        <div class="card" style="padding: 16px; background: var(--bg-card); display: flex; align-items: center; justify-content: center; height: 450px; overflow: hidden; border: 1px solid var(--border-color);">
            @if($product->image_path)
                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" style="max-height: 100%; max-width: 100%; object-fit: contain; border-radius: var(--radius-md);">
            @else
                <div style="font-size: 120px;">👟</div>
            @endif
        </div>

        <!-- Right: Purchase Controls & Specs -->
        <div class="card" style="padding: 40px; background: var(--bg-card);">
            <!-- Category and Brand -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: var(--accent-blue); border: 1px solid rgba(59, 130, 246, 0.2);">
                    {{ $product->category->name }}
                </span>
                
                <span style="font-size: 13px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">
                    Бренд: <span style="color: white;">{{ $product->brand }}</span>
                </span>
            </div>

            <!-- Title -->
            <h1 style="font-size: 32px; line-height: 1.2; margin-bottom: 20px; font-family: var(--font-heading); color: #ffffff;">
                {{ $product->name }}
            </h1>

            <!-- Rating overview if reviews exist -->
            @if($product->reviews->count() > 0)
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
                    <div style="color: #fbbf24; font-size: 16px;">
                        @php $avgRating = round($product->reviews->avg('rating')); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            {!! $i <= $avgRating ? '★' : '☆' !!}
                        @endfor
                    </div>
                    <span style="font-size: 13px; color: var(--text-secondary);">
                        ({{ $product->reviews->count() }} {{ trans_choice('отзыв|отзыва|отзывов', $product->reviews->count(), [], 'ru') }})
                    </span>
                </div>
            @endif

            <!-- Price Card -->
            <div style="background: var(--bg-input); border-radius: var(--radius-md); border: 1px solid var(--border-color); padding: 24px; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <span style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">Цена товара:</span>
                    <div style="display: flex; align-items: baseline; gap: 12px;">
                        @if($product->promo_price !== null)
                            <strong style="font-size: 28px; font-weight: 800; color: var(--accent-emerald);">
                                {{ number_format($product->promo_price, 0, '.', ' ') }} ₽
                            </strong>
                            <span style="font-size: 16px; color: var(--text-secondary); text-decoration: line-through;">
                                {{ number_format($product->price, 0, '.', ' ') }} ₽
                            </span>
                        @else
                            <strong style="font-size: 28px; font-weight: 800; color: white;">
                                {{ number_format($product->price, 0, '.', ' ') }} ₽
                            </strong>
                        @endif
                    </div>
                </div>

                <div>
                    <span style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 4px; text-align: right;">Наличие:</span>
                    @if($product->stock > 0)
                        <span class="badge badge-completed" style="padding: 6px 12px;">На складе ({{ $product->stock }} шт)</span>
                    @else
                        <span class="badge badge-cancelled" style="padding: 6px 12px;">Нет в наличии</span>
                    @endif
                </div>
            </div>

            <!-- Add to Cart Form -->
            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    
                    <!-- Choose Size -->
                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="form-label" for="product-size-select" style="font-weight: 600; color: white;">Выберите ваш размер:</label>
                        <select name="size" id="product-size-select" class="form-control" style="padding: 12px; font-weight: 600;" required>
                            <option value="" disabled selected>-- Выберите размер --</option>
                            @foreach(explode(',', $product->sizes) as $sz)
                                <option value="{{ trim($sz) }}">{{ trim($sz) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity and Button -->
                    <div style="display: grid; grid-template-columns: 120px 1fr; gap: 16px; align-items: end;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="product-qty-input">Кол-во:</label>
                            <input type="number" name="quantity" id="product-qty-input" class="form-control" value="1" min="1" max="{{ $product->stock }}" style="padding: 10px; font-weight: 600; text-align: center;">
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="padding: 12px; width: 100%; height: 46px; justify-content: center; font-size: 15px;">
                            <span>🛒</span> Добавить в корзину
                        </button>
                    </div>
                </form>
            @else
                <div style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: var(--radius-sm); padding: 16px 20px; text-align: center;">
                    <p style="color: #ef4444; font-weight: 600; font-size: 14px;">К сожалению, данного товара сейчас нет в наличии. Вы можете связаться с менеджером для оформления предзаказа.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Long Description -->
    <div class="card" style="margin-bottom: 64px; padding: 40px;">
        <h2 style="font-size: 22px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
            Описание товара
        </h2>
        <p style="color: var(--text-secondary); font-size: 15px; line-height: 1.8; white-space: pre-line;">
            {{ $product->description }}
        </p>
    </div>

    <!-- Reviews Section -->
    <div class="grid-2" style="margin-bottom: 64px; align-items: start;">
        <!-- Left: Reviews List -->
        <div>
            <h2 style="font-size: 22px; margin-bottom: 24px;">Отзывы о товаре</h2>
            
            <div style="display: grid; gap: 20px;">
                @forelse($product->reviews as $rev)
                    <div class="card" style="padding: 20px; background: var(--bg-card);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <div>
                                <strong style="color: white; font-size: 14px;">{{ $rev->user->name }}</strong>
                                <span style="display: block; font-size: 11px; color: var(--text-secondary);">
                                    {{ $rev->created_at->format('d.m.Y H:i') }}
                                </span>
                            </div>
                            
                            <div style="color: #fbbf24; font-size: 12px;">
                                @for($i = 1; $i <= 5; $i++)
                                    {!! $i <= $rev->rating ? '★' : '☆' !!}
                                @endfor
                            </div>
                        </div>
                        
                        <p style="color: var(--text-primary); font-size: 13px; line-height: 1.5; white-space: pre-line;">
                            {{ $rev->comment }}
                        </p>
                    </div>
                @empty
                    <div class="card" style="text-align: center; padding: 48px;">
                        <span style="font-size: 32px;">💬</span>
                        <h3 style="margin-top: 12px; margin-bottom: 4px;">Отзывов о товаре нет</h3>
                        <p style="color: var(--text-secondary); font-size: 13px;">Будьте первым, кто поделится своим мнением об этом товаре!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Submit Review Form -->
        <div class="card" style="padding: 32px; position: sticky; top: 100px;">
            <h2 style="font-size: 22px; margin-bottom: 12px;">Написать отзыв о товаре</h2>
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 24px;">Помогите другим покупателям определиться с размером, качеством и посадкой этой модели.</p>

            @auth
                <form action="{{ route('catalog.review.store', $product->slug) }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">Ваша оценка модели</label>
                        <div style="display: flex; gap: 12px; margin-top: 4px;">
                            @for($i = 5; $i >= 1; $i--)
                                <label style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #fbbf24; font-size: 14px; font-weight: 600;">
                                    <input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} style="accent-color: var(--accent-emerald);">
                                    @for($s = 1; $s <= 5; $s++)
                                        {!! $s <= $i ? '★' : '☆' !!}
                                    @endfor
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="prod-comment">Ваш комментарий</label>
                        <textarea name="comment" id="prod-comment" class="form-control" rows="5" placeholder="Расскажите о качестве швов, плотности ткани, подошве кроссовок и соответствует ли товар размерной сетке..." required minlength="5" maxlength="1000"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">Отправить на модерацию</button>
                </form>
            @else
                <div style="background: var(--bg-input); border-radius: var(--radius-sm); border: 1px solid var(--border-color); padding: 24px; text-align: center;">
                    <span style="font-size: 32px; display: block; margin-bottom: 12px;">🔒</span>
                    <h3 style="margin-bottom: 8px;">Авторизуйтесь для написания отзыва</h3>
                    <p style="color: var(--text-secondary); font-size: 12px; margin-bottom: 20px;">Написать отзыв о товаре могут только зарегистрированные пользователи.</p>
                    
                    <div style="display: flex; justify-content: center; gap: 12px;">
                        <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Войти</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Регистрация</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection
