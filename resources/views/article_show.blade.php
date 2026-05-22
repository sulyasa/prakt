@extends('layouts.app')

@section('title', $article->title . ' | Блог Velocity')
@section('meta_description', Str::limit(strip_tags($article->content), 150))

@section('content')
    <div style="max-width: 800px; margin: 0 auto; margin-bottom: 64px;">
        <!-- Back Link -->
        <a href="{{ route('articles.index') }}" style="color: var(--accent-blue); font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 32px;">
            &larr; Назад к полезным статьям
        </a>

        <!-- Article Cover -->
        <div style="background: var(--bg-card); border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border-color); margin-bottom: 32px; height: 350px; display: flex; align-items: center; justify-content: center;">
            @if($article->image_path)
                <img src="{{ asset($article->image_path) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <span style="font-size: 96px;">📰</span>
            @endif
        </div>

        <!-- Meta -->
        <span style="font-size: 13px; color: var(--accent-emerald); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-bottom: 12px;">
            Опубликовано: {{ $article->created_at->format('d.m.Y') }}
        </span>

        <!-- Title -->
        <h1 style="font-size: 38px; line-height: 1.1; margin-bottom: 24px; font-family: var(--font-heading); color: #ffffff;">
            {{ $article->title }}
        </h1>

        <!-- Content -->
        <div style="color: var(--text-primary); font-size: 16px; line-height: 1.8; text-align: justify; white-space: pre-line;">
            {!! $article->content !!}
        </div>
    </div>
@endsection
