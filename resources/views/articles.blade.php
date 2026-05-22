@extends('layouts.app')

@section('title', 'Полезные статьи о спорте и экипировке | Velocity')
@section('meta_description', 'Экспертные статьи, рекомендации по выбору спортивной одежды и обуви, обзоры технологий и советы для эффективных тренировок.')

@section('content')
    <div style="margin-bottom: 48px; text-align: center; max-width: 680px; margin-left: auto; margin-right: auto;">
        <h1 style="font-size: 36px; margin-bottom: 12px; font-family: var(--font-heading);">Полезные статьи</h1>
        <p style="color: var(--text-secondary); font-size: 15px;">Советы, обзоры технологий и практические рекомендации для тех, кто стремится к лучшим результатам.</p>
    </div>

    <div class="grid-3" style="margin-bottom: 64px;">
        @forelse($articles as $article)
            <div class="card" style="display: flex; flex-direction: column; height: 100%;">
                <div style="background: var(--bg-input); border-radius: var(--radius-md); height: 180px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid var(--border-color); margin-bottom: 20px;">
                    @if($article->image_path)
                        <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span style="font-size: 48px;">📰</span>
                    @endif
                </div>

                <span style="font-size: 12px; color: var(--accent-blue); font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">
                    {{ $article->created_at->format('d.m.Y') }}
                </span>
                
                <h2 style="font-size: 18px; margin-bottom: 12px; font-family: var(--font-heading); line-height: 1.3;">
                    <a href="{{ route('articles.show', $article->slug) }}" style="color: #ffffff;">{{ $article->title }}</a>
                </h2>
                
                <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 20px; flex: 1;">
                    {{ Str::limit(strip_tags($article->content), 120) }}
                </p>

                <div style="margin-top: auto;">
                    <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-secondary btn-sm" style="width: 100%; justify-content: center;">
                        Читать далее &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 48px;">
                <span style="font-size: 48px;">📭</span>
                <h3 style="margin-top: 16px; margin-bottom: 8px;">Статьи отсутствуют</h3>
                <p style="color: var(--text-secondary);">В данный момент на сайте нет опубликованных полезных статей.</p>
            </div>
        @endforelse
    </div>
@endsection
