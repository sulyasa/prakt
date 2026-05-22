@extends('layouts.app')

@section('title', 'Отзывы о магазине | Velocity Sport')
@section('meta_description', 'Читайте отзывы наших покупателей и делитесь своими впечатлениями о качестве товаров и уровне обслуживания в магазине Velocity.')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="font-size: 36px; margin-bottom: 8px;">Отзывы покупателей</h1>
        <p style="color: var(--text-secondary);">Мы гордимся нашей репутацией и ценим мнение каждого клиента. Ваши отзывы помогают нам становиться лучше.</p>
    </div>

    <div class="grid-2" style="margin-bottom: 64px; align-items: start;">
        <!-- Left: Reviews Feed -->
        <div>
            <h2 style="font-size: 22px; margin-bottom: 24px;">Что говорят о нашем магазине</h2>
            
            <div style="display: grid; gap: 20px;">
                @forelse($reviews as $review)
                    <div class="card" style="padding: 24px; border-left: 4px solid var(--accent-emerald);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <div>
                                <strong style="color: #ffffff; font-size: 15px;">{{ $review->user->name }}</strong>
                                <span style="display: block; font-size: 11px; color: var(--text-secondary);">
                                    {{ $review->created_at->format('d.m.Y H:i') }}
                                </span>
                            </div>
                            
                            <!-- Stars rendering -->
                            <div style="color: #fbbf24; font-size: 14px;">
                                @for($i = 1; $i <= 5; $i++)
                                    {!! $i <= $review->rating ? '★' : '☆' !!}
                                @endfor
                            </div>
                        </div>
                        
                        <p style="color: var(--text-primary); font-size: 14px; line-height: 1.5; white-space: pre-line;">
                            {{ $review->comment }}
                        </p>
                    </div>
                @empty
                    <div class="card" style="text-align: center; padding: 48px;">
                        <span style="font-size: 40px;">💬</span>
                        <h3 style="margin-top: 16px; margin-bottom: 8px;">Отзывов пока нет</h3>
                        <p style="color: var(--text-secondary);">Будьте первым, кто оставит свой отзыв о нашем магазине!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Submit Review Form -->
        <div class="card" style="padding: 32px; position: sticky; top: 100px;">
            <h2 style="font-size: 22px; margin-bottom: 12px;">Оставить отзыв</h2>
            <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 24px;">Пожалуйста, поделитесь своими впечатлениями от покупки. Ваши слова помогут другим сделать правильный выбор.</p>

            @auth
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">Ваша оценка</label>
                        <div class="rating-select" style="display: flex; gap: 12px; margin-top: 4px;">
                            @for($i = 5; $i >= 1; $i--)
                                <label style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #fbbf24; font-size: 16px; font-weight: 600;">
                                    <input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} style="accent-color: var(--accent-emerald);">
                                    @for($s = 1; $s <= 5; $s++)
                                        {!! $s <= $i ? '★' : '☆' !!}
                                    @endfor
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="review-comment">Ваш отзыв</label>
                        <textarea name="comment" id="review-comment" class="form-control" rows="6" placeholder="Напишите, что вам понравилось, как быстро доставили заказ и довольны ли вы качеством..." required minlength="5" maxlength="1000"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">Отправить отзыв</button>
                </form>
            @else
                <div style="background: var(--bg-input); border-radius: var(--radius-sm); border: 1px solid var(--border-color); padding: 24px; text-align: center;">
                    <span style="font-size: 32px; display: block; margin-bottom: 12px;">🔒</span>
                    <h3 style="margin-bottom: 8px;">Авторизуйтесь, чтобы оставить отзыв</h3>
                    <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">Оставлять отзывы о магазине могут только зарегистрированные пользователи.</p>
                    
                    <div style="display: flex; justify-content: center; gap: 12px;">
                        <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Войти</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Регистрация</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection
