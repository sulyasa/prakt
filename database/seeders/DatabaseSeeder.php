<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Article;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@sportshop.ru'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '+7 (999) 777-77-77',
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'user@sportshop.ru'],
            [
                'name' => 'Иван Иванов',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'phone' => '+7 (999) 111-22-33',
            ]
        );

        $customer2 = User::firstOrCreate(
            ['email' => 'maria@sportshop.ru'],
            [
                'name' => 'Мария Петрова',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'phone' => '+7 (999) 444-55-66',
            ]
        );


        // 2. Categories
        $catClothing = Category::create([
            'name' => 'Спортивная одежда',
            'slug' => 'odezhda',
            'description' => 'Качественная и удобная спортивная одежда для тренировок и повседневной жизни.'
        ]);

        $catFootwear = Category::create([
            'name' => 'Спортивная обувь',
            'slug' => 'obuv',
            'description' => 'Кроссовки для бега, фитнеса и силовых тренировок от ведущих мировых брендов.'
        ]);

        $catAccs = Category::create([
            'name' => 'Аксессуары',
            'slug' => 'aksessuary',
            'description' => 'Рюкзаки, бутылки для воды, фитнес-браслеты и другие полезные мелочи.'
        ]);

        // 3. Products
        // Clothing
        $p1 = Product::create([
            'category_id' => $catClothing->id,
            'name' => 'Спортивный костюм Nike Tech Fleece',
            'slug' => 'nike-tech-fleece-suit',
            'description' => 'Легендарный спортивный костюм из инновационного материала Tech Fleece. Отлично сохраняет тепло, не утяжеляя образ. Идеальный крой и стильный дизайн.',
            'price' => 12999.00,
            'brand' => 'Nike',
            'sizes' => 'S, M, L, XL',
            'image_path' => null, // We can upload or let it render a beautiful placeholder
            'stock' => 15,
            'is_active' => true,
        ]);

        $p2 = Product::create([
            'category_id' => $catClothing->id,
            'name' => 'Ветровка Adidas Own the Run',
            'slug' => 'adidas-own-the-run-jacket',
            'description' => 'Легкая влагоотталкивающая ветровка для бега в прохладную погоду. Светоотражающие детали обеспечат безопасность в темное время суток.',
            'price' => 6499.00,
            'brand' => 'Adidas',
            'sizes' => 'S, M, L',
            'image_path' => null,
            'stock' => 20,
            'is_active' => true,
        ]);

        $p3 = Product::create([
            'category_id' => $catClothing->id,
            'name' => 'Худи Puma Power Sweatshirt',
            'slug' => 'puma-power-sweatshirt',
            'description' => 'Уютное повседневное худи с контрастным логотипом Puma. Выполнено из мягкого хлопкового трикотажа с начесом. Карман-кенгуру спереди.',
            'price' => 5499.00,
            'promo_price' => 3999.00,
            'brand' => 'Puma',
            'sizes' => 'M, L, XL',
            'image_path' => null,
            'stock' => 12,
            'is_active' => true,
        ]);

        $p4 = Product::create([
            'category_id' => $catClothing->id,
            'name' => 'Легинсы Reebok Lux Bold',
            'slug' => 'reebok-lux-bold-leggings',
            'description' => 'Компрессионные спортивные легинсы с оригинальным принтом. Технология Speedwick отводит влагу, сохраняя сухость и комфорт на протяжении всей тренировки.',
            'price' => 4999.00,
            'brand' => 'Reebok',
            'sizes' => 'XS, S, M',
            'image_path' => null,
            'stock' => 8,
            'is_active' => true,
        ]);

        // Footwear
        $p5 = Product::create([
            'category_id' => $catFootwear->id,
            'name' => 'Кроссовки Nike Air Max 270',
            'slug' => 'nike-air-max-270',
            'description' => 'Стильные кроссовки с самой большой воздушной подушкой Air в пятке. Гарантируют непревзойденный комфорт и амортизацию в течение всего дня.',
            'price' => 14999.00,
            'brand' => 'Nike',
            'sizes' => '41, 42, 43, 44',
            'image_path' => null,
            'stock' => 10,
            'is_active' => true,
        ]);

        $p6 = Product::create([
            'category_id' => $catFootwear->id,
            'name' => 'Кроссовки Adidas Ultraboost 22',
            'slug' => 'adidas-ultraboost-22',
            'description' => 'Лучшие беговые кроссовки с технологией Boost. Возврат энергии при каждом шаге, трикотажный верх Primeknit для плотной и комфортной посадки.',
            'price' => 18999.00,
            'promo_price' => 15499.00,
            'brand' => 'Adidas',
            'sizes' => '40, 41, 42, 43',
            'image_path' => null,
            'stock' => 14,
            'is_active' => true,
        ]);

        $p7 = Product::create([
            'category_id' => $catFootwear->id,
            'name' => 'Кроссовки Puma Velocity Nitro 2',
            'slug' => 'puma-velocity-nitro-2',
            'description' => 'Легкие и технологичные кроссовки для бега на любые дистанции. Вспененная подошва Nitro обеспечивает взрывную отзывчивость и мягкость.',
            'price' => 11999.00,
            'brand' => 'Puma',
            'sizes' => '42, 43, 44',
            'image_path' => null,
            'stock' => 5,
            'is_active' => true,
        ]);

        $p8 = Product::create([
            'category_id' => $catFootwear->id,
            'name' => 'Кроссовки Reebok Nano X3',
            'slug' => 'reebok-nano-x3',
            'description' => 'Универсальные кроссовки для кроссфита и функциональных тренировок. Усиленный каркас подошвы для устойчивости при приседаниях и прыжках.',
            'price' => 13499.00,
            'brand' => 'Reebok',
            'sizes' => '40, 41, 42, 43, 44',
            'image_path' => null,
            'stock' => 18,
            'is_active' => true,
        ]);

        // Accessories
        $p9 = Product::create([
            'category_id' => $catAccs->id,
            'name' => 'Рюкзак Nike Brasilia M',
            'slug' => 'nike-brasilia-backpack',
            'description' => 'Вместительный спортивный рюкзак с отделением для ноутбука и влажным карманом для обуви после тренировки. Уплотненные плечевые лямки.',
            'price' => 3499.00,
            'brand' => 'Nike',
            'sizes' => 'One Size',
            'image_path' => null,
            'stock' => 25,
            'is_active' => true,
        ]);

        $p10 = Product::create([
            'category_id' => $catAccs->id,
            'name' => 'Бутылка для воды Adidas Steel 0.75L',
            'slug' => 'adidas-steel-bottle',
            'description' => 'Прочная стальная бутылка для воды с карабином для крепления к рюкзаку. Долго сохраняет воду прохладной. Герметичная крышка.',
            'price' => 1999.00,
            'brand' => 'Adidas',
            'sizes' => 'One Size',
            'image_path' => null,
            'stock' => 50,
            'is_active' => true,
        ]);

        // 4. Articles
        Article::create([
            'title' => 'Как правильно выбрать кроссовки для бега?',
            'slug' => 'kak-vybrat-krossovki-dlya-bega',
            'content' => 'Бег — один из самых популярных и доступных видов спорта, но неправильный выбор обуви может привести к травмам суставов и связок. При выборе беговых кроссовок обратите внимание на следующие параметры:\n\n1. **Амортизация:** Для асфальта нужна максимальная амортизация (подошва с гелем, воздухом или пеной).\n2. **Тип пронации:** Пронация — это способ постановки стопы при ходьбе и беге. Бывает нейтральная, гипопронация и гиперпронация. Для гиперпронаторов нужны кроссовки с поддержкой стопы.\n3. **Размер:** Беговые кроссовки должны быть на 0.5-1 размер больше повседневных, так как при беге стопа отекает и смещается вперед.\n\nВ каталоге нашего магазина вы найдете такие технологичные линейки, как Adidas Ultraboost и Puma Velocity Nitro, которые обеспечат комфорт и защиту ваших стоп.',
            'image_path' => null
        ]);

        Article::create([
            'title' => 'Топ-5 упражнений для разминки перед тренировкой',
            'slug' => 'top-5-uprazhneniy-dlya-razminki',
            'content' => 'Разминка — обязательная часть любой тренировки. Она разогревает мышцы, подготавливает сердечно-сосудистую систему к нагрузкам и снижает риск растяжений. Вот пять базовых упражнений для идеальной суставной разминки:\n\n1. **Вращение шеей и плечами:** По 10 круговых движений в каждую сторону.\n2. **Наклоны корпуса:** Ноги на ширине плеч, наклоняйтесь поочередно к левой ноге, центру и правой ноге.\n3. **Вращение тазом:** Круговые движения тазом с широкой амплитудой.\n4. **Приседания без веса:** 15 классических приседаний для разогрева квадрицепсов и ягодиц.\n5. **Бег на месте или прыжки "Jumping Jacks":** 1-2 минуты для повышения пульса.\n\nПомните, качественная разминка занимает 10-15 минут и подготавливает тело к максимальной продуктивности!',
            'image_path' => null
        ]);

        Article::create([
            'title' => 'Преимущества технологичных спортивных тканей',
            'slug' => 'preimushestva-sportivnyh-tkaney',
            'content' => 'Современная спортивная одежда давно ушла от обычного хлопка. При интенсивных тренировках хлопок быстро впитывает влагу, тяжелеет и прилипает к телу, вызывая дискомфорт и переохлаждение. Технологичные синтетические ткани имеют ряд неоспоримых преимуществ:\n\n- **Отвод влаги:** Ткани типа Nike Dri-FIT или Reebok Speedwick не впитывают пот, а выводят его на внешнюю поверхность волокон, откуда он быстро испаряется.\n- **Терморегуляция:** Зимняя одежда, например Nike Tech Fleece, сохраняет тепло тела при минимальном весе за счет прослоек воздуха в структуре волокон.\n- **Эластичность и прочность:** Добавление спандекса позволяет одежде растягиваться во всех направлениях, не сковывая движений и не теряя форму со временем.\n\nИнвестируйте в правильную спортивную экипировку, и ваши тренировки станут в разы приятнее и эффективнее!',
            'image_path' => null
        ]);

        // 5. Promotions
        Promotion::create([
            'title' => 'Летний Сейл - Скидки до 40%!',
            'slug' => 'summer-sale',
            'description' => 'Успейте обновить свой спортивный гардероб к лету! Специальные сниженные цены на беговые кроссовки и легкие ветровки от топовых брендов. Акция действует до конца месяца.',
            'discount_percent' => 40,
            'image_path' => null,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);

        Promotion::create([
            'title' => 'В здоровом теле - здоровый дух! Скидка 15% на всё при регистрации',
            'slug' => 'welcome-promo',
            'description' => 'Каждый новый зарегистрированный пользователь получает приветственную скидку 15% на свой первый заказ спортивной одежды или обуви. Регистрируйтесь прямо сейчас!',
            'discount_percent' => 15,
            'image_path' => null,
            'start_date' => now(),
            'end_date' => now()->addDays(365),
        ]);

        // 6. Settings
        Setting::create([
            'key' => 'manager_phone',
            'value' => '+7 (999) 123-45-67',
            'description' => 'Телефон менеджера для кнопки "Позвонить" и шапки сайта'
        ]);

        Setting::create([
            'key' => 'shop_address',
            'value' => 'г. Москва, ул. Спортивная, д. 42',
            'description' => 'Физический адрес магазина'
        ]);

        Setting::create([
            'key' => 'shop_email',
            'value' => 'info@sportshop.ru',
            'description' => 'Контактный E-mail магазина'
        ]);

        Setting::create([
            'key' => 'shop_hours',
            'value' => 'Пн-Вс: 10:00 - 22:00',
            'description' => 'Режим работы магазина'
        ]);

        // 7. Reviews
        // Store Reviews (product_id is null)
        Review::create([
            'user_id' => $customer->id,
            'product_id' => null,
            'rating' => 5,
            'comment' => 'Отличный магазин! Очень быстрая доставка. Заказывал кроссовки Nike Air Max 270 - привезли в тот же день, качество супер! Обязательно буду заказывать еще.',
            'is_approved' => true,
        ]);

        Review::create([
            'user_id' => $customer2->id,
            'product_id' => null,
            'rating' => 5,
            'comment' => 'Прекрасный ассортимент спортивной одежды. Удобный сайт, легко оформить заказ. Кнопка звонка менеджеру сработала мгновенно, мне вежливо ответили на все вопросы по размерам.',
            'is_approved' => true,
        ]);

        Review::create([
            'user_id' => $customer->id,
            'product_id' => null,
            'rating' => 4,
            'comment' => 'Хороший магазин, но хотелось бы больше выбора в разделе аксессуаров. Качество костюма Nike отличное.',
            'is_approved' => false, // Pending moderation
        ]);

        // Product Reviews
        Review::create([
            'user_id' => $customer2->id,
            'product_id' => $p6->id, // Ultraboost
            'rating' => 5,
            'comment' => 'Это лучшая беговая обувь, которая у меня когда-либо была! Амортизация просто невероятная, бежишь словно по облакам. Большое спасибо магазину за скидку!',
            'is_approved' => true,
        ]);

        Review::create([
            'user_id' => $customer->id,
            'product_id' => $p1->id, // Tech Fleece
            'rating' => 5,
            'comment' => 'Супер костюм! Теплый, легкий, стильный. Сидит идеально по фигуре. Доставили оригинальный товар в оригинальной упаковке со всеми бирками.',
            'is_approved' => true,
        ]);

        Review::create([
            'user_id' => $customer2->id,
            'product_id' => $p3->id, // Puma Hoodie
            'rating' => 4,
            'comment' => 'Классное мягкое худи, очень уютное. Немного большемерит, но для оверсайз стиля в самый раз.',
            'is_approved' => false, // Pending moderation
        ]);
    }
}
