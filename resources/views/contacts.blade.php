@extends('layouts.app')

@section('title', 'Контакты | Интернет-магазин Velocity')
@section('meta_description', 'Свяжитесь с нами по телефону, почте или посетите наш шоурум в Москве. Карта расположения и подробный режим работы.')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="font-size: 36px; margin-bottom: 8px;">Контакты</h1>
        <p style="color: var(--text-secondary);">Мы всегда рады помочь вам с выбором спортивной экипировки. Свяжитесь с нами любым удобным способом.</p>
    </div>

    <div class="grid-2" style="margin-bottom: 48px; align-items: start;">
        <!-- Contact Info Cards -->
        <div>
            <div class="card" style="margin-bottom: 24px; padding: 32px;">
                <h2 style="font-size: 22px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                    <span style="color: var(--accent-emerald);">📍</span> Наш шоурум
                </h2>
                
                <div style="display: grid; gap: 20px;">
                    <div>
                        <span style="display: block; font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">Адрес:</span>
                        <p style="font-size: 15px; font-weight: 500; color: white;">
                            {{ \App\Models\Setting::get('shop_address', 'г. Москва, ул. Спортивная, д. 42') }}
                        </p>
                    </div>

                    <div>
                        <span style="display: block; font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">Телефон отдела продаж:</span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', \App\Models\Setting::get('manager_phone', '+7 (999) 123-45-67')) }}" style="font-size: 18px; font-weight: 700; color: var(--accent-emerald);">
                            {{ \App\Models\Setting::get('manager_phone', '+7 (999) 123-45-67') }}
                        </a>
                        <span style="display: block; font-size: 11px; color: var(--text-secondary); margin-top: 4px;">(Звонок бесплатный по всей России)</span>
                    </div>

                    <div class="grid-2" style="gap: 16px;">
                        <div>
                            <span style="display: block; font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">E-mail:</span>
                            <a href="mailto:{{ \App\Models\Setting::get('shop_email', 'info@sportshop.ru') }}" style="color: var(--accent-blue); font-weight: 500;">
                                {{ \App\Models\Setting::get('shop_email', 'info@sportshop.ru') }}
                            </a>
                        </div>
                        <div>
                            <span style="display: block; font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">Режим работы:</span>
                            <p style="font-weight: 500; color: white;">
                                {{ \App\Models\Setting::get('shop_hours', 'Пн-Вс: 10:00 - 22:00') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Interactive Map -->
            <div class="card" style="padding: 10px; overflow: hidden; height: 350px;">
                <iframe src="https://www.google.com/maps/embed?pb=!11m18!1m12!1m3!1d2248.8778643806144!2d37.534887377196024!3d55.699797073063546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54cf605dc7981%3s0x46b54cf5ed4a13fd!2sLomonosovsky%20Prospekt%2C%20Moscow!5e0!3m2!1sen!2sru!4v1714578129524!5m2!1sen!2sru" 
                        width="100%" height="100%" style="border:0; border-radius: var(--radius-md);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Feedback Form -->
        <div class="card" style="padding: 32px;">
            <h2 style="font-size: 22px; margin-bottom: 16px;">Напишите нам</h2>
            <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 28px;">Есть вопросы или предложения по улучшению магазина? Заполните форму, и мы ответим в течение часа.</p>
            
            @if(session('contact_success'))
                <div class="alert alert-success" style="margin-bottom: 24px;">
                    <span>✅</span> {{ session('contact_success') }}
                </div>
            @endif

            <form action="#" method="GET" onsubmit="event.preventDefault(); alert('Сообщение успешно отправлено! Наш менеджер свяжется с вами по указанному email.'); this.reset();">
                <div class="form-group">
                    <label class="form-label" for="contact-name">Ваше имя</label>
                    <input type="text" id="contact-name" class="form-control" placeholder="Иван Иванов" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="contact-email">Ваш E-mail</label>
                    <input type="email" id="contact-email" class="form-control" placeholder="ivan@example.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="contact-phone">Телефон (необязательно)</label>
                    <input type="text" id="contact-phone" class="form-control" placeholder="+7 (999) 000-00-00">
                </div>

                <div class="form-group">
                    <label class="form-label" for="contact-message">Сообщение</label>
                    <textarea id="contact-message" class="form-control" rows="5" placeholder="Введите ваше сообщение здесь..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">Отправить сообщение</button>
            </form>
        </div>
    </div>
@endsection
