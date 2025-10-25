@extends('front.master')

@section('content')
    <main class="container new-arrivals-page">

        <div class="breadcrumb">
            <div class="container">
                <a href="{{ url('/') }}">الصفحة الرئيسية</a>
                <span>›</span>
                <span>المفضلة</span>
            </div>
        </div>

        <div class="container profile-page">
            @include('front.profile.sidebar')

            <div class="profile-main">
                <h1 class="profile-title">💖 المفضلة</h1>

                @if ($wishlists->isEmpty())
                    <p class="empty-text text-center">لا توجد منتجات في المفضلة حالياً.</p>
                @else
                    <div class="wishlist-grid">
                        @foreach ($wishlists as $wish)
                            <div class="wishlist-card">
                                <img src="{{ asset('storage/' . $wish->product->image) }}" alt="{{ $wish->product->name }}">
                                <div class="wishlist-info">
                                    <h4>{{ $wish->product->name }}</h4>
                                    <p class="price">{{ number_format($wish->product->price, 2) }} ر.س</p>
                                    <div class="wishlist-actions">
                                        <button class="wishlist-btn toggle-wishlist"
                                            data-product="{{ $wish->product->id }}">
                                            <span class="heart">💔</span> <span class="text">إزالة من المفضلة</span>
                                        </button>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>

    <style>
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }

        .wishlist-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .wishlist-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .wishlist-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .wishlist-info {
            padding: 15px;
            text-align: center;
        }

        .price {
            color: #28a745;
            font-weight: 600;
        }

        .wishlist-actions {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
    <script>
        document.querySelectorAll('.toggle-wishlist').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const productId = this.getAttribute('data-product');

                fetch("{{ route('wishlist.toggle') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        // إنشاء Toast جميل ومتحرك
                        const toast = document.createElement('div');
                        toast.textContent = data.message;
                        toast.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: ${data.status === 'added' ? '#28a745' : '#dc3545'};
                color: white;
                padding: 12px 18px;
                border-radius: 10px;
                font-size: 15px;
                z-index: 9999;
                opacity: 0;
                transform: translateY(20px);
                box-shadow: 0 4px 14px rgba(0,0,0,0.15);
                transition: all 0.4s ease;
            `;
                        document.body.appendChild(toast);

                        // تشغيل الحركة
                        setTimeout(() => {
                            toast.style.opacity = '1';
                            toast.style.transform = 'translateY(0)';
                        }, 50);

                        // إخفاء الـ toast بعد 2.5 ثانية
                        setTimeout(() => {
                            toast.style.opacity = '0';
                            toast.style.transform = 'translateY(20px)';
                            setTimeout(() => toast.remove(), 400);
                        }, 2500);

                        // إزالة المنتج مباشرة بدون تحديث الصفحة
                        if (data.status === 'removed') {
                            const card = this.closest('.wishlist-card');
                            if (card) {
                                card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                                card.style.opacity = '0';
                                card.style.transform = 'scale(0.95)';
                                setTimeout(() => card.remove(), 400);
                            }
                        }
                    })
                    .catch(() => {
                        const errorToast = document.createElement('div');
                        errorToast.textContent = 'حدث خطأ أثناء معالجة الطلب 😢';
                        errorToast.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: #ff4444;
                color: white;
                padding: 12px 18px;
                border-radius: 10px;
                font-size: 15px;
                z-index: 9999;
                box-shadow: 0 4px 14px rgba(0,0,0,0.15);
            `;
                        document.body.appendChild(errorToast);
                        setTimeout(() => errorToast.remove(), 2500);
                    });
            });
        });
    </script>

@endsection
