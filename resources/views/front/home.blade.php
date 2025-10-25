@extends('front.master')
@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-image-container">
                <img src="{{ asset('assets/front/img/hero2.jpg') }}" loading="lazy" alt="Hero Image" class="hero-image">
                <div class="hero-overlay">
                    <div class="hero-content">
                        <h1 class="hero-title">
                            العصر الجديد<br>
                            للأزياء
                        </h1>
                        <p class="hero-subtitle">خريف / شتاء 2025</p>
                        <p class="hero-description">
                            ادخل موسمًا من الأناقة الجريئة، حيث يلتقي التصميم الحديث
                            بالأنوثة الخالدة. اكتشف قوة الأسلوب.
                        </p>
                        <a href="#" class="hero-cta">تسوق الآن</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Season's Highlights -->
    <section class="highlights-section">
        <div class="highlights-container">
            <h2 class="section-text font-playfair slide-up delay-200">إبرازات الموسم</h2>
            <div class="highlights-grid">
                @foreach ($categories as $index => $category)
                    <div class="highlight-item slide-up delay-{{ 300 + $index * 100 }}"> <img
                            src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy"
                            class="highlight-image">
                        <div class="highlight-overlay">
                            <h3 class="highlight-title">{!! $category->description ?? 'اكتشف أحدث منتجاتنا' !!}</h3> <a href=""
                                class="highlight-cta"> تسوق {{ $category->name }} </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <!-- Product Grid -->
    <section class="products-section">
        <div class="products-container">
            <h2 class="section-text font-playfair slide-up delay-200"> الرائج هذا الأسبوع
            </h2>

            <div class="products-grid">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product->id) }}"
                        class="product-card slide-up delay-200 no-hover-bg">
                        <div class="product-image-container">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/default.png') }}"
                                alt="{{ $product->name }}" loading="lazy" class="product-image">
                            <button type="button" class="wishlist-button" data-id="{{ $product->id }}"
                                title="أضف إلى المفضلة">
                                <i class="{{ in_array($product->id, $wishlistIds ?? []) ? 'fas' : 'far' }} fa-heart"
                                    style="{{ in_array($product->id, $wishlistIds ?? []) ? 'color: var(--secondary);' : '' }}"></i>
                            </button>


                        </div>
                        <div class="product-info">
                            <h3 class="product-brand">{{ $product->name }}</h3>
                            <p class="product-description">{{ Str::limit($product->description, 50) }}</p>
                            <p class="product-price">{{ number_format($product->price, 2) }} EGP</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>



    <!-- About Section -->
    <section class="about-us-section">
        <div class="about-us-container">
            <div class="about-us-image-container">
                <img src="assets/front/img/cover3.jpg" alt="تجربة الأناقة" loading="lazy" class="about-us-image">
                <div class="about-us-overlay-left">
                    <p class="about-us-text slide-up delay-200">
                        في متجرنا، نعيد تعريف الأناقة العصرية.
                        نختار بعناية كل قطعة لتلائم ذوقك وتبرز شخصيتك،
                        مع التركيز على الجودة، التفرد، والأسلوب الراقي لكل موسم.
                    </p>
                    <a href="#" class="about-us-cta slide-up delay-300">اكتشف قصتنا</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Static Collection Section -->
    <section class="static-collection-section" style="padding: 4rem 0; background: #fff8f8;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <h2 class="section-text font-playfair slide-up delay-200"> الكوليكشن الخاص بنا
            </h2>


            <div class="collection-grid"
                style="display: flex; gap: 2rem; overflow-x: auto; scroll-behavior: smooth; padding-bottom: 1rem;">

                <!-- Collection Item 1 -->
                <div class="collection-card slide-up delay-300"
                    style="flex: 0 0 280px; border-radius: 2rem; overflow: hidden; position: relative; box-shadow: 0 12px 30px rgba(0,0,0,0.15); transition: transform 0.5s, box-shadow 0.5s; cursor: pointer;">
                    <img src="{{ asset('assets/front/img/prod9.jpg') }}" alt="كوليكشن صيفي" loading="lazy"
                        style="width: 100%; height: 300px; object-fit: cover; transition: transform 0.5s;">
                    <div class="collection-overlay"
                        style="position: absolute; inset: 0; background: rgba(154, 131, 132, 0.5); opacity: 0; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: opacity 0.3s;">
                        <h3 style="color: #fff; font-weight: 700; font-size: 1.2rem; margin-bottom: 0.5rem;">كوليكشن صيفي
                        </h3>
                        <p style="color: #fff; text-align: center; font-size: 0.95rem;">أحدث صيحات الصيف لأناقتك اليومية.
                        </p>
                        <a href="#"
                            style="margin-top: 0.8rem; padding: 0.5rem 1.5rem; background: #fff; color: #e63946; border-radius: 2rem; font-weight: 600; text-decoration: none; transition: background 0.3s;">
                            اكتشف الكوليكشن
                        </a>
                    </div>
                </div>

                <!-- Collection Item 2 -->
                <div class="collection-card slide-up delay-400"
                    style="flex: 0 0 280px; border-radius: 2rem; overflow: hidden; position: relative; box-shadow: 0 12px 30px rgba(0,0,0,0.15); transition: transform 0.5s, box-shadow 0.5s; cursor: pointer;">
                    <img src="{{ asset('assets/front/img/prod7.jpg') }}" alt="كوليكشن شتوي" loading="lazy"
                        style="width: 100%; height: 300px; object-fit: cover; transition: transform 0.5s;">
                    <div class="collection-overlay"
                        style="position: absolute; inset: 0; background:rgba(154, 131, 132, 0.5); opacity: 0; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: opacity 0.3s;">
                        <h3 style="color: #fff; font-weight: 700; font-size: 1.2rem; margin-bottom: 0.5rem;">كوليكشن شتوي
                        </h3>
                        <p style="color: #fff; text-align: center; font-size: 0.95rem;">تشكيلة الشتاء الدافئة بألوان راقية.
                        </p>
                        <a href="#"
                            style="margin-top: 0.8rem; padding: 0.5rem 1.5rem; background: #fff; color: #e63946; border-radius: 2rem; font-weight: 600; text-decoration: none; transition: background 0.3s;">
                            اكتشف الكوليكشن
                        </a>
                    </div>
                </div>

                <!-- Collection Item 3 -->
                <div class="collection-card slide-up delay-500"
                    style="flex: 0 0 280px; border-radius: 2rem; overflow: hidden; position: relative; box-shadow: 0 12px 30px rgba(0,0,0,0.15); transition: transform 0.5s, box-shadow 0.5s; cursor: pointer;">
                    <img src="{{ asset('assets/front/img/prod8.jpg') }}" alt="كوليكشن مناسبات" loading="lazy"
                        style="width: 100%; height: 300px; object-fit: cover; transition: transform 0.5s;">
                    <div class="collection-overlay"
                        style="position: absolute; inset: 0; background:rgba(154, 131, 132, 0.5); opacity: 0; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: opacity 0.3s;">
                        <h3 style="color: #fff; font-weight: 700; font-size: 1.2rem; margin-bottom: 0.5rem;">كوليكشن مناسبات
                        </h3>
                        <p style="color: #fff; text-align: center; font-size: 0.95rem;">تصاميم رائعة لكل المناسبات الخاصة.
                        </p>
                        <a href="#"
                            style="margin-top: 0.8rem; padding: 0.5rem 1.5rem; background: #fff; color: #e63946; border-radius: 2rem; font-weight: 600; text-decoration: none; transition: background 0.3s;">
                            اكتشف الكوليكشن
                        </a>
                    </div>
                </div>
                <!-- Collection Item 3 -->
                <div class="collection-card slide-up delay-500"
                    style="flex: 0 0 280px; border-radius: 2rem; overflow: hidden; position: relative; box-shadow: 0 12px 30px rgba(0,0,0,0.15); transition: transform 0.5s, box-shadow 0.5s; cursor: pointer;">
                    <img src="{{ asset('assets/front/img/prod1-1.jpg') }}" alt="كوليكشن مناسبات" loading="lazy"
                        style="width: 100%; height: 300px; object-fit: cover; transition: transform 0.5s;">
                    <div class="collection-overlay"
                        style="position: absolute; inset: 0; background:rgba(154, 131, 132, 0.5); opacity: 0; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: opacity 0.3s;">
                        <h3 style="color: #fff; font-weight: 700; font-size: 1.2rem; margin-bottom: 0.5rem;">كوليكشن
                            مناسبات</h3>
                        <p style="color: #fff; text-align: center; font-size: 0.95rem;">تصاميم رائعة لكل المناسبات الخاصة.
                        </p>
                        <a href="#"
                            style="margin-top: 0.8rem; padding: 0.5rem 1.5rem; background: #fff; color: #e63946; border-radius: 2rem; font-weight: 600; text-decoration: none; transition: background 0.3s;">
                            اكتشف الكوليكشن
                        </a>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="carousel-nav-buttons"
                style="display: flex; justify-content: center; gap: 1rem; margin-top: 2rem;">
                <button class="carousel-prev"
                    style="background: #e63946; color: #fff; border: none; padding: 0.5rem 1rem; border-radius: 2rem;">&#10094;</button>
                <button class="carousel-next"
                    style="background: #e63946; color: #fff; border: none; padding: 0.5rem 1rem; border-radius: 2rem;">&#10095;</button>
            </div>
        </div>
    </section>


    <!-- سكشن إكسسوارات الأزياء -->
    <section class="accessories-promo-section-ar" style="margin: 2rem 0;">
        <div class="about-us-container"
            style="display: flex; align-items: center; justify-content: space-between; background: #daa6a6; border-radius: 2rem; padding: 2.5rem 2rem; gap: 2rem; flex-wrap: wrap;">
            <!-- النص -->
            <div style="flex: 1 1 320px; color: #fff; min-width: 260px; direction: rtl;">
                <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.1;">
                    إكسسوارات عصرية. لمسة تكمّل أناقتك.
                </h2>
                <p style="font-size: 1.1rem; margin-bottom: 2rem;">
                    اكتشف مجموعتنا المختارة من الإكسسوارات التي تضيف لمسة فريدة لكل إطلالة. حقائب، أحزمة، نظارات وأكثر،
                    جميعها بتصاميم عصرية وجودة عالية.
                </p>
                <a href="#"
                    style="display: inline-block; background: #fff; color: #323030; font-weight: 600; padding: 0.75rem 2rem; border-radius: 2rem; font-size: 1.1rem; text-decoration: none; transition: background 0.2s;"
                    onmouseover="this.style.background='#eee'" onmouseout="this.style.background='#fff'">
                    تسوق الإكسسوارات
                </a>
            </div>
            <!-- الصور -->
            <div style="display: flex; gap: 1.5rem; flex: 1 1 400px; justify-content: flex-end; min-width: 320px;">
                <img src="{{ asset('assets/front/img/prod1.jpg') }}" alt="حقيبة يد"
                    style="width: 150px; height: 200px; object-fit: cover; border-radius: 1rem; transform: rotate(-8deg); box-shadow: 0 4px 24px #0002;">
                <img src="{{ asset('assets/front/img/prod2.jpg') }}" alt="نظارات شمس"
                    style="width: 150px; height: 200px; object-fit: cover; border-radius: 1rem; transform: rotate(6deg); box-shadow: 0 4px 24px #0002;">
                <img src="{{ asset('assets/front/img/prod3.jpg') }}" alt="حزام أنيق"
                    style="width: 150px; height: 200px; object-fit: cover; border-radius: 1rem; transform: rotate(-4deg); box-shadow: 0 4px 24px #0002;">
            </div>
        </div>
    </section>
    <!-- Sneakers Carousel -->
    {{-- <section class="sneakers-section">
        <div class="sneakers-container">
            <h2 class="sneakers-header font-playfair slide-up delay-200">أحذية رياضية موسم جديد</h2>
            <div class="carousel-container">
                <button class="carousel-nav prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="carousel-track">
                    <div class="carousel-card slide-up delay-300">
                        <div class="sneaker-card">
                            <img src="{{ asset('assets/front/img/prod1.jpg') }}" alt="Prada Sneakers" loading="lazy"
                                class="sneaker-image">
                            <div class="sneaker-info">
                                <span class="sneaker-badge">موسم جديد</span>
                                <h3 class="sneaker-brand">PRADA</h3>
                                <p class="sneaker-description">أحذية داون تاون في الجلد</p>
                                <p class="sneaker-price">4,180 EGP</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-card slide-up delay-400">
                        <div class="sneaker-card">
                            <img src="{{ asset('assets/front/img/prod10.jpg') }}" alt="Jacquemus Sneakers" loading="lazy"
                                class="sneaker-image">
                            <div class="sneaker-info">
                                <span class="sneaker-badge">موسم جديد</span>
                                <h3 class="sneaker-brand">JACQUEMUS</h3>
                                <p class="sneaker-description">أحذية التنس في النقش...</p>
                                <p class="sneaker-price">1,650 EGP</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-card slide-up delay-500">
                        <div class="sneaker-card">
                            <img src="{{ asset('assets/front/img/prod4.jpg') }}" alt="Dolce & Gabbana Sneakers"
                                loading="lazy" class="sneaker-image">
                            <div class="sneaker-info">
                                <span class="sneaker-badge">موسم جديد</span>
                                <h3 class="sneaker-brand">DOLCE & GABBANA</h3>
                                <p class="sneaker-description">أحذية بورتوفينو منخفضة في ...</p>
                                <p class="sneaker-price">3,050 EGP</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-card slide-up delay-600">
                        <div class="sneaker-card">
                            <img src="{{ asset('assets/front/img/Watch4.jpg') }}" alt="Golden Goose Sneakers"
                                loading="lazy" class="sneaker-image">
                            <div class="sneaker-info">
                                <span class="sneaker-badge">موسم جديد</span>
                                <h3 class="sneaker-brand">GOLDEN GOOSE</h3>
                                <p class="sneaker-description">أحذية بال ستار في السويد والل...</p>
                                <p class="sneaker-price">2,468 EGP</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-card slide-up delay-700">
                        <div class="sneaker-card">
                            <img src="{{ asset('assets/front/img/prod5.jpg') }}" alt="Salomon Sneakers" loading="lazy"
                                class="sneaker-image">
                            <div class="sneaker-info">
                                <span class="sneaker-badge">موسم جديد</span>
                                <h3 class="sneaker-brand">SALOMON</h3>
                                <p class="sneaker-description">أحذية ACS + OG في الشبكة</p>
                                <p class="sneaker-price">772 EGP</p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-nav next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section> --}}

    <!-- Newsletter and App Section -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-grid">
                <div class="cta-card slide-up delay-200">
                    <img src="{{ asset('assets/front/img/Shopping.jpg') }}" loading="lazy" alt="Amber"
                        class="cta-image">
                    <p class="cta-text">استمتع بمكافآت حصرية وعروض للأعضاء فقط.</p>
                    <button class="cta-button float">انضم أو سجل الدخول</button>
                </div>
                <div class="cta-card slide-up delay-300">
                    <img src="{{ asset('assets/front/img/Shoppinginterface.jpg') }}" loading="lazy" alt="App Screenshot"
                        class="app-screenshot">


                </div>
                <div class="cta-card slide-up delay-400">
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">
                        تواصل معنا مباشرة لطلبك الأول
                    </h3>
                    <p class="cta-text">اتصل بنا على</p>
                    <p class="app-code">+20 123 456 789</p>
                    <p class="cta-text" style="margin-bottom: 1.5rem;">أو عبر واتساب</p>
                    <div class="app-stores">
                        <a href="https://wa.me/20123456789" target="_blank">
                            <img src="https://placehold.co/200x50/25D366/ffffff?text=Chat+on+WhatsApp" loading="lazy"
                                alt="WhatsApp" class="app-store">
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Image Modal -->
    <div class="image-modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="modal-close">&times;</button>
            <img id="modal-image" src="" alt="Product Image">
        </div>
    </div>
    <script>
        // Hover effect
        document.querySelectorAll('.collection-card').forEach(card => {
            const overlay = card.querySelector('.collection-overlay');
            const img = card.querySelector('img');
            card.addEventListener('mouseenter', () => {
                overlay.style.opacity = '1';
                img.style.transform = 'scale(1.1)';
                card.style.transform = 'scale(1.05)';
                card.style.boxShadow = '0 25px 50px rgba(0,0,0,0.25)';
            });
            card.addEventListener('mouseleave', () => {
                overlay.style.opacity = '0';
                img.style.transform = 'scale(1)';
                card.style.transform = 'scale(1)';
                card.style.boxShadow = '0 12px 30px rgba(0,0,0,0.15)';
            });
        });

        // Carousel scroll buttons
        const carousel = document.querySelector('.collection-grid');
        const prevBtn = document.querySelector('.carousel-prev');
        const nextBtn = document.querySelector('.carousel-next');

        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        });
        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        });
    </script>
    <script>

    </script>
@endsection
