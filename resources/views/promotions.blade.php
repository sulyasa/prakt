@extends('layouts.app')

@section('title', 'Акции и спецпредложения | Velocity')
@section('meta_description', 'Скидки на спортивную одежду и обувь в интернет-магазине Velocity. Текущие акции, промо-предложения и подарки при покупках.')

@section('content')
    <div style="margin-bottom: 48px; text-align: center; max-width: 680px; margin-left: auto; margin-right: auto;">
        <h1 style="font-size: 36px; margin-bottom: 12px; font-family: var(--font-heading);">Акции и спецпредложения</h1>
        <p style="color: var(--text-secondary); font-size: 15px;">Покупайте качественную экипировку с выгодой. Специальные предложения со скидками до 40% и подарками.</p>
    </div>

    <div style="display: grid; gap: 32px; margin-bottom: 64px;">
        @forelse($promotions as $promo)
            <div class="card" style="display: grid; grid-template-columns: 300px 1fr; gap: 32px; padding: 32px; align-items: center;">
                <!-- Image -->
                <div style="background: var(--bg-input); border-radius: var(--radius-md); height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid var(--border-color);">
                    @if($promo->image_path)
                        <img src="{{ asset($promo->image_path) }}" alt="{{ $promo->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span style="font-size: 80px; color: var(--accent-emerald);">🎁</span>
                    @endif
                </div>

                <!-- Info -->
                <div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        @if($promo->discount_percent)
                            <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 14px; padding: 6px 12px; font-weight: 700;">
                                Скидка -{{ $promo->discount_percent }}%
                            </span>
                        @endif

                        @if($promo->end_date)
                            <span style="font-size: 12px; color: var(--text-secondary);">
                                📅 Активно до: {{ $promo->end_date->format('d.m.Y') }}
                            </span>
                        @endif
                    </div>

                    <h2 style="font-size: 24px; margin-bottom: 12px; color: #ffffff; font-family: var(--font-heading);">
                        {{ $promo->title }}
                    </h2>
                    
                    <p style="color: var(--text-secondary); font-size: 15px; margin-bottom: 24px; line-height: 1.5;">
                        {{ $promo->description }}
                    </p>

                    <div>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary">
                            Перейти к покупкам &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card" style="text-align: center; padding: 64px;">
                <span style="font-size: 64px;">🏷️</span>
                <h3 style="margin-top: 16px; margin-bottom: 8px;">Акции временно отсутствуют</h3>
                <p style="color: var(--text-secondary); max-width: 420px; margin: 0 auto;">Сейчас у нас нет активных акций, но мы готовим для вас новые невероятные скидки! Загляните позже.</p>
            </div>
        @endforelse
    </div>
@endsection
