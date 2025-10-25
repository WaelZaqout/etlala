<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إطلالة متجر الأزياء الفاخرة</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Latest Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/media.css') }}">

</head>
@yield('css')

<body>
    <div class="loading-screen">
        <div class="loading-logo font-playfair">إطلالة</div>
        <div class="loading-progress">
            <div class="loading-bar"></div>
        </div>
        <div class="loading-text">جارٍ تحميل التجربة</div>
    </div>
    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>
    <div class="mobile-menu">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 class="font-playfair" style="font-size: 1.875rem; font-weight: 700; color: var(--black);">إطلالة</h1>
            <button class="mobile-menu-close"
                style="background: none; border: none; color: var(--black); font-size: 1.875rem;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="margin-bottom: 2rem;">
            <div style="position: relative; margin-bottom: 1rem;">
                <input type="text" placeholder="البحث عن مصمم أو منتج"
                    style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 1rem; background: var(--white); color: var(--black); border-radius: 2rem; border: 1px solid var(--gray-300); font-size: 1rem; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                <i class="fas fa-search"
                    style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-500);"></i>
            </div>
        </div>

        <!-- القوائم (Accordion) -->
        <div style="margin-bottom: 2rem;">
            <h3 style="color: var(--black); font-weight: 600; font-size: 1.125rem; margin-bottom: 1rem;">الفئات</h3>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">

                <details>
                    <summary
                        style="cursor:pointer; padding:0.75rem; border-radius:0.5rem; color:var(--gray-700); font-weight:500;">
                        ما وصل حديثا</summary>
                    <div style="padding:0.5rem 1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        <a href="#">الوافدات الجديدات للنساء</a>
                        <a href="#">الوافدات الجديدات للرجال</a>
                        <a href="#">الوافدات الجديدات للأطفال</a>
                        <a href="#">الرائج الآن</a>
                        <a href="#">الإطلاقات الحصرية</a>
                    </div>
                </details>

                <details>
                    <summary
                        style="cursor:pointer; padding:0.75rem; border-radius:0.5rem; color:var(--gray-700); font-weight:500;">
                        المصممون</summary>
                    <div style="padding:0.5rem 1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        <a href="#">المصممون من أ إلى ي</a>
                        <a href="#">المصممون الجدد</a>
                        <a href="#">برادا</a>
                        <a href="#">غوتشي</a>
                        <a href="#">بالنسياغا</a>
                        <a href="#">فالنتينو</a>
                    </div>
                </details>

                <details>
                    <summary
                        style="cursor:pointer; padding:0.75rem; border-radius:0.5rem; color:var(--gray-700); font-weight:500;">
                        الملابس</summary>
                    <div style="padding:0.5rem 1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        <a href="#">الفساتين</a>
                        <a href="#">القمصان</a>
                        <a href="#">السراويل</a>
                        <a href="#">الملابس الخارجية</a>
                        <a href="#">مجموعات المصممين</a>
                    </div>
                </details>

                <details>
                    <summary
                        style="cursor:pointer; padding:0.75rem; border-radius:0.5rem; color:var(--gray-700); font-weight:500;">
                        الأحذية</summary>
                    <div style="padding:0.5rem 1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        <a href="#">الكعب العالي</a>
                        <a href="#">الأحذية المسطحة</a>
                        <a href="#">الأحذية الطويلة</a>
                        <a href="#">الصنادل</a>
                        <a href="#">أحذية المصممين</a>
                    </div>
                </details>

                <details>
                    <summary
                        style="cursor:pointer; padding:0.75rem; border-radius:0.5rem; color:var(--gray-700); font-weight:500;">
                        الأحذية الرياضية</summary>
                    <div style="padding:0.5rem 1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        <a href="#">الأحذية المنخفضة</a>
                        <a href="#">الأحذية العالية</a>
                        <a href="#">الأحذية الرياضية للمصممين</a>
                        <a href="#">نايكي</a>
                        <a href="#">أديداس</a>
                        <a href="#">نيو بالانس</a>
                    </div>
                </details>

                <details>
                    <summary
                        style="cursor:pointer; padding:0.75rem; border-radius:0.5rem; color:var(--gray-700); font-weight:500;">
                        الإكسسوارات</summary>
                    <div style="padding:0.5rem 1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        <a href="#">المجوهرات</a>
                        <a href="#">الأحزمة</a>
                        <a href="#">القبعات والقفازات</a>
                        <a href="#">النظارات الشمسية</a>
                        <a href="#">إكسسوارات المصممين</a>
                    </div>
                </details>

                <details>
                    <summary
                        style="cursor:pointer; padding:0.75rem; border-radius:0.5rem; color:var(--gray-700); font-weight:500;">
                        العناية الشخصية</summary>
                    <div style="padding:0.5rem 1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        <a href="#">العطور</a>
                        <a href="#">عناية البشرة</a>
                        <a href="#">عناية الشعر</a>
                        <a href="#">عناية الجسم</a>
                        <a href="#">العلامات الفاخرة</a>
                    </div>
                </details>

                <details>
                    <summary
                        style="cursor:pointer; padding:0.75rem; border-radius:0.5rem; color:var(--secondary); font-weight:600;">
                        تخفيضات</summary>
                    <div style="padding:0.5rem 1rem; display:flex; flex-direction:column; gap:0.5rem;">
                        <a href="#">تخفيضات النساء</a>
                        <a href="#">تخفيضات الرجال</a>
                        <a href="#">تخفيضات الأطفال</a>
                        <a href="#">خصم يصل إلى 50%</a>
                        <a href="#">التخفيض النهائي</a>
                    </div>
                </details>

            </div>
        </div>

        <!-- الحساب + باقي الخيارات كما هي -->
        <div style="margin-bottom: 2rem;">
            <h3 style="color: var(--black); font-weight: 600; font-size: 1.125rem; margin-bottom: 1rem;">الحساب</h3>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('profile') }}"><i class="fas fa-user"></i> الحساب</a>
                <a href="#"><i class="fas fa-heart"></i> قائمة الرغبات (0)</a>
                <a href="{{ route('cart.index') }}" class="cart-link">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-badge">{{ $cartCount }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <!-- Top Bar -->
    <div class="top-bar">
        ✨ شحن مجاني عند الطلب فوق 500 جنيه ✨
    </div>

    <header class="main-header">
        <div class="header-container">
            <!-- Logo -->
            <div class="logo">
                <h1><a href="{{ route('Home') }}">إطلالة</a></h1>
            </div>

            <!-- Navigation -->
            <nav class="main-nav">
                <a href="{{ route('new') }}">ما وصل حديثا</a>
                <a href="#">المصممون</a>
                <a href="#">الملابس</a>
                <a href="#">الأحذية</a>
                <a href="#">الإكسسوارات</a>
                <a href="#">تخفيضات</a>
            </nav>

            <!-- Icons -->
            <div class="header-icons" style="display: flex; align-items: center; gap: 18px;">

                <a href="#" style="color: #000;"><i class="fas fa-search"></i></a>

                @auth
                    <div class="user-menu" style="position: relative;">
                        <button
                            style="width: 42px; height: 42px; border-radius: 50%; background-color: #f2f2f2; color: #333; font-weight: bold; text-transform: uppercase; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; font-size: 14px;">
                            @if (Auth::user()->image)
                                <img src="{{ asset('uploads/users/' . Auth::user()->image) }}" alt="Profile"
                                    style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover;">
                            @else
                                {{ mb_substr(Auth::user()->name, 0, 2) }}
                            @endif
                        </button>

                        <!-- القائمة المنسدلة -->
                        <div class="dropdown-menu"
                            style="display: none; position: absolute; right: 0; top: 40px; background: #fff; border: 1px solid #ddd; border-radius: 10px; width: 180px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 50; overflow: hidden;">
                            <a href="{{ route('profile') }}"
                                style="display: block; padding: 10px 15px; color: #333; text-decoration: none; transition: 0.2s;">
                                الملف الشخصي
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit"
                                    style="width: 100%; text-align: right; padding: 10px 15px; background: none; border: none; cursor: pointer; color: #333; transition: 0.2s;">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('user.login') }}" style="color: #000;"><i class="far fa-user"></i></a>
                @endauth

                <!-- ❤️ المفضلة -->
                <div class="wishlist-dropdown-container">
                    <a href="#" class="wishlist-icon">
                        <i class="far fa-heart"></i>
                        @if ($wishlistCount > 0)
                            <span class="cart-count">{{ $wishlistCount }}</span>
                        @endif
                    </a>

                    <div class="wishlist-dropdown">
                        @if ($wishlistItems->isNotEmpty())
                            @foreach ($wishlistItems->take(2) as $item)
                                <div class="wishlist-item">
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}">
                                    <div class="wishlist-details">
                                        <p class="wishlist-name">{{ $item->product->name }}</p>
                                        <span class="wishlist-price">{{ number_format($item->product->price, 2) }}
                                            ر.س</span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="wishlist-footer">
                                <a href="{{ route('profile.wishlist') }}">عرض المزيد</a>
                            </div>
                        @else
                            <div class="wishlist-empty">
                                <p>لا توجد منتجات في المفضلة.</p>
                            </div>
                        @endif
                    </div>
                </div>


                <!-- 🛍️ السلة -->
                <a href="{{ route('cart.index') }}" style="color: #000; position: relative;">
                    <i class="fas fa-shopping-bag"></i>
                    @if ($cartCount > 0)
                        <span class="cart-count"
                            style="position: absolute; top: -8px; right: -10px; background-color: #b08b57; color: #fff; border-radius: 50%; font-size: 10px; padding: 2px 5px;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

            </div>



        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-grid">
                <div>
                    <h3>اشترك في نشرتنا الإخبارية</h3>
                    <p style="color: var(--gray-400); margin-bottom: 1rem; font-size: 0.9375rem;">احصل على أحدث
                        التحديثات حول الوافدات الجديدة، العروض الحصرية، والمزيد.</p>
                    <div class="newsletter-form">
                        <input type="email" placeholder="your.email@example.com" class="newsletter-input">
                        <button class="newsletter-button">اشترك</button>
                    </div>
                </div>
                <div>
                    <h3>تابع إطلالة</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div>
                    <h3>العلامات التجارية الرائدة</h3>
                    <ul class="footer-links">
                        <li><a href="#">Prada</a></li>
                        <li><a href="#">Gucci</a></li>
                        <li><a href="#">Balenciaga</a></li>
                        <li><a href="#">Valentino</a></li>
                        <li><a href="#">Fendi</a></li>
                        <li><a href="#">Bottega Veneta</a></li>
                    </ul>
                </div>
                <div>
                    <h3>الفئات الرائدة</h3>
                    <ul class="footer-links">
                        <li><a href="#">الملابس</a></li>
                        <li><a href="#">الأحذية</a></li>
                        <li><a href="#">الأحذية الرياضية</a></li>
                        <li><a href="#">الإكسسوارات</a></li>
                        <li><a href="#">العناية الشخصية</a></li>
                        <li><a href="#">الحقائب</a></li>
                    </ul>
                </div>
                <div>
                    <h3>خدمة العملاء</h3>
                    <ul class="footer-links">
                        <li><a href="#">اتصل بنا</a></li>
                        <li><a href="#">الأسئلة الشائعة</a></li>
                        <li><a href="#">الدفع</a></li>
                        <li><a href="#">تتبع الطلب</a></li>
                        <li><a href="#">الإرجاع والتبادل</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom-grid">
                    <div>
                        <div class="footer-logo">
                            <img src="https://placehold.co/60x60/1a1a1a/ffffff?text=LOGO" alt="Logo">
                            <span style="color: var(--gray-400); font-weight: 500;">الموطن النهائي للفخامة</span>
                        </div>
                    </div>
                    <div>
                        <p class="footer-contact">
                            Contact Customer Care: <a href="tel:97444196400">974 44196400</a><br>
                            WhatsApp Customer Care: <a href="tel:97144223100">97144223100</a>
                        </p>
                    </div>
                    <div>
                        <h3
                            style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 1rem; text-transform: uppercase; color: var(--white);">
                            حولنا</h3>
                        <ul class="footer-links">
                            <li><a href="#">حول أوناس</a></li>
                            <li><a href="#">الوظائف</a></li>
                            <li><a href="#">الصحافة</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3
                            style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 1rem; text-transform: uppercase; color: var(--white);">
                            القانوني</h3>
                        <ul class="footer-links">
                            <li><a href="#">الشروط والأحكام</a></li>
                            <li><a href="#">سياسة الخصوصية وملفات تعريف الارتباط</a></li>
                            <li><a href="#">مطابقة السعر</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3
                            style="font-size: 0.9375rem; font-weight: 600; margin-bottom: 1rem; text-transform: uppercase; color: var(--white);">
                            الشحن والإرجاع</h3>
                        <ul class="footer-links">
                            <li><a href="#">الشحن والتسليم</a></li>
                            <li><a href="#">الإرجاع عبر الإنترنت</a></li>
                            <li><a href="#">الشحن الدولي</a></li>
                        </ul>
                        <div class="footer-apps">
                            <h3 class="footer-apps-title">تطبيقات إطلالة</h3>
                            <div class="footer-apps-links">
                                <a href="#">
                                    <img src="https://placehold.co/120x40/1a1a1a/ffffff?text=App+Store"
                                        alt="App Store">
                                </a>
                                <a href="#">
                                    <img src="https://placehold.co/120x40/1a1a1a/ffffff?text=Google+Play"
                                        alt="Google Play">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-copyright">
                    <div class="footer-copyright-content">
                        <p>Al Tayer Group LLC. 2025. All Rights Reserved</p>
                        <img src="https://placehold.co/150x40/1a1a1a/ffffff?text=AL+TAYER" alt="Al Tayer">
                    </div>
                </div>
            </div>
        </div>
    </footer>


    @yield('js')

    <script src="{{ asset('assets/front/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wishlistButtons = document.querySelectorAll('.wishlist-button');

            wishlistButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const icon = this.querySelector('i');

                    fetch("{{ route('wishlist.toggle') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // 🔸 إظهار إشعار جميل
                            Swal.fire({
                                icon: data.status === 'added' ? 'success' : 'info',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // 🔸 تغيير شكل الأيقونة فورًا
                            if (data.status === 'added') {
                                icon.classList.remove('far');
                                icon.classList.add('fas', 'text-danger');
                            } else if (data.status === 'removed') {
                                icon.classList.remove('fas', 'text-danger');
                                icon.classList.add('far');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'حدث خطأ أثناء العملية 😞',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = userMenu?.querySelector('.dropdown-menu');

            if (userMenu && dropdown) {
                userMenu.addEventListener('mouseenter', () => dropdown.style.display = 'block');
                userMenu.addEventListener('mouseleave', () => dropdown.style.display = 'none');
            }
        });
    </script>

</body>

</html>
