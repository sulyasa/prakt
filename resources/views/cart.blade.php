@extends('layouts.app')

@section('title', 'Ваша корзина | Velocity')

@section('content')
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 36px; margin-bottom: 8px;">Корзина</h1>
        <p style="color: var(--text-secondary);">Управляйте выбранными товарами и переходите к быстрому оформлению заказа.</p>
    </div>

    @if(empty($cart))
        <!-- Empty Cart State -->
        <div class="card" style="text-align: center; padding: 64px; max-width: 600px; margin: 0 auto; margin-bottom: 64px;">
            <span style="font-size: 72px;">🛒</span>
            <h2 style="margin-top: 24px; margin-bottom: 12px; font-family: var(--font-heading);">Ваша корзина пуста</h2>
            <p style="color: var(--text-secondary); margin-bottom: 32px; font-size: 15px;">Вы еще не добавили ни одного товара в корзину. Самое время обновить гардероб технологичной экипировкой!</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="padding: 12px 32px;">Перейти в каталог</a>
        </div>
    @else
        <!-- Cart layout: items + checkout form -->
        <div class="grid-2" style="margin-bottom: 64px; align-items: start;">
            
            <!-- Left: List of items -->
            <div>
                <h2 style="font-size: 20px; margin-bottom: 20px;">Выбранные товары ({{ count($cart) }})</h2>
                
                <div style="display: grid; gap: 16px;">
                    @foreach($cart as $key => $item)
                        <div class="card" style="display: grid; grid-template-columns: 80px 1fr 120px 100px 40px; gap: 20px; align-items: center; padding: 16px;">
                            <!-- Image slot -->
                            <div style="background: var(--bg-input); border-radius: var(--radius-sm); height: 80px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid var(--border-color);">
                                @if($item['image_path'])
                                    <img src="{{ asset($item['image_path']) }}" alt="{{ $item['name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span style="font-size: 36px;">👟</span>
                                @endif
                            </div>

                            <!-- Details -->
                            <div>
                                <span style="font-size: 11px; font-weight: 700; color: var(--accent-blue); text-transform: uppercase;">{{ $item['brand'] }}</span>
                                <h3 style="font-size: 15px; font-weight: 600; color: white; line-height: 1.2; margin-top: 2px; margin-bottom: 4px;">
                                    <a href="{{ route('catalog.show', \Illuminate\Support\Str::slug($item['name'])) }}" style="color: white;">{{ $item['name'] }}</a>
                                </h3>
                                <span style="font-size: 12px; color: var(--text-secondary);">
                                    Размер: <strong style="color: white;">{{ $item['size'] }}</strong>
                                </span>
                            </div>

                            <!-- Quantity controls -->
                            <form action="{{ route('cart.update', $key) }}" method="POST" style="margin: 0;">
                                @csrf
                                <div style="display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: 4px; overflow: hidden; background: var(--bg-input);">
                                    <!-- Simple select drop or small number input for instant change! -->
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width: 100%; text-align: center; border: none; background: transparent; color: white; font-size: 13px; font-weight: 600; padding: 6px 4px;" onchange="this.form.submit();">
                                </div>
                            </form>

                            <!-- Subtotal -->
                            <div style="text-align: right;">
                                <strong style="font-size: 16px; color: var(--accent-emerald);">
                                    {{ number_format($item['price'] * $item['quantity'], 0, '.', ' ') }} ₽
                                </strong>
                                <span style="display: block; font-size: 11px; color: var(--text-secondary);">
                                    {{ number_format($item['price'], 0, '.', ' ') }} ₽ / шт
                                </span>
                            </div>

                            <!-- Remove trigger -->
                            <form action="{{ route('cart.remove', $key) }}" method="POST" style="margin: 0; text-align: right;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 6px 8px; border-radius: 4px;" title="Удалить из корзины">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
                
                <!-- Quick total summary card -->
                <div class="card" style="margin-top: 24px; padding: 24px; display: flex; align-items: center; justify-content: space-between; background: var(--bg-secondary);">
                    <span style="font-size: 16px; color: var(--text-secondary); font-weight: 600;">Итого к оплате:</span>
                    <strong style="font-size: 26px; color: white;">{{ number_format($total, 0, '.', ' ') }} ₽</strong>
                </div>
            </div>

            <!-- Right: Checkout details -->
            <div class="card" style="padding: 32px;">
                <h2 style="font-size: 20px; margin-bottom: 8px;">Оформление заказа</h2>
                <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 24px;">Заполните форму доставки, чтобы подтвердить ваш заказ.</p>

                @auth
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label" for="chk-name">ФИО получателя</label>
                            <input type="text" name="contact_name" id="chk-name" class="form-control" value="{{ Auth::user()->name }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="chk-phone">Контактный телефон</label>
                            <input type="text" name="contact_phone" id="chk-phone" class="form-control" value="{{ Auth::user()->phone }}" placeholder="+7 (999) 000-00-00" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="chk-address">Адрес доставки</label>
                            @php
                                // Fetch default user address if exists
                                $defaultAddr = Auth::user()->addresses()->where('is_default', true)->first();
                                $defaultAddrText = $defaultAddr ? $defaultAddr->address : '';
                            @endphp
                            <textarea name="delivery_address" id="chk-address" class="form-control" rows="4" placeholder="Введите полный адрес: город, улица, дом, квартира/офис..." required>{{ $defaultAddrText }}</textarea>
                            
                            @if(Auth::user()->addresses()->count() > 0)
                                <div style="margin-top: 8px;">
                                    <span style="font-size: 11px; color: var(--text-secondary); display: block; margin-bottom: 4px;">Ваши сохраненные адреса:</span>
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        @foreach(Auth::user()->addresses as $addr)
                                            <button type="button" class="btn btn-secondary btn-sm" style="text-align: left; padding: 6px 10px; font-size: 11px; width: 100%; border-color: rgba(255,255,255,0.05);" onclick="document.getElementById('chk-address').value = '{{ addslashes($addr->address) }}';">
                                                🏡 {{ $addr->address }} {{ $addr->is_default ? '(По умолчанию)' : '' }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <span style="display: block; font-size: 11px; color: var(--text-secondary); margin-top: 6px;">Вы можете сохранить этот адрес в вашем <a href="{{ route('cabinet.addresses') }}" style="color: var(--accent-blue);">Личном кабинете</a> для будущих покупок.</span>
                            @endif
                        </div>

                        <div style="margin-top: 32px;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
                                Подтвердить и оформить заказ
                            </button>
                        </div>
                    </form>
                @else
                    <div style="background: var(--bg-input); border-radius: var(--radius-sm); border: 1px solid var(--border-color); padding: 32px; text-align: center;">
                        <span style="font-size: 40px; display: block; margin-bottom: 16px;">🔒</span>
                        <h3 style="margin-bottom: 8px;">Авторизуйтесь для оформления заказа</h3>
                        <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 24px;">Оформление покупок доступно только зарегистрированным клиентам магазина.</p>
                        
                        <div style="display: flex; justify-content: center; gap: 12px;">
                            <a href="{{ route('login') }}" class="btn btn-secondary">Войти</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
                        </div>
                    </div>
                @endauth
            </div>

        </div>
    @endif
@endsection
