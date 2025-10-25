@extends('front.master')
@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <div class="container">
            <a href="#">رجال</a> ›
            <a href="#">إكسسوارات</a> ›
            <a href="#">حقائب</a> ›
            <span>حقيبة تومي هيلفيغر الكاجوال</span>
        </div>
    </div>

    <!-- Product Page -->
    <main class="container">
        <div class="product-page">
            <div class="product-images">
                <div class="thumbnails">
                    @foreach ($product->images as $img)
                        <div class="thumbnail animate-fade-in">
                            <img src="{{ asset('storage/' . $img->image) }}" loading="lazy" alt="{{ $product->name }}">
                        </div>
                    @endforeach
                </div>

                <div class="main-image-container">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/default.png') }}"
                        alt="{{ $product->name }}" class="main-image">
                    <div class="image-controls">
                        <div class="image-control">‹</div>
                        <div class="image-control">›</div>
                    </div>
                </div>




                <!-- Image Modal -->
                <div id="imageModal" class="image-modal">
                    <span class="close-modal">&times;</span>
                    <img class="modal-content" id="modalImage">
                </div>
            </div>

            <div class="product-info">
                <h1 class="product-title">{{ $product->brand ?? 'غير محدد' }}</h1>
                <h2 class="product-name">{{ $product->name }}</h2>

                <div class="price-quantity">
                    {{-- السعر --}}
                    <div class="price">
                        @php
                            $finalPrice =
                                $product->sale_price && $product->sale_price < $product->price
                                    ? $product->sale_price
                                    : $product->price;
                        @endphp

                        @if ($product->sale_price && $product->sale_price < $product->price)
                            <span class="original-price">{{ number_format($product->price, 2) }} ريال</span>
                            <span id="unitPrice" data-price="{{ $finalPrice }}">{{ number_format($finalPrice, 2) }}
                                ريال</span>
                            <span class="discount">
                                خصم {{ round(100 - ($product->sale_price / $product->price) * 100) }}%
                            </span>
                        @else
                            <span id="unitPrice" data-price="{{ $finalPrice }}">{{ number_format($finalPrice, 2) }}
                                ريال</span>
                        @endif
                    </div>

                    {{-- التحكم في الكمية --}}
                    <div class="quantity-control">
                        <button type="button" class="quantity-btn decrease">-</button>
                        <input type="number" name="quantity" id="quantityInput" class="quantity-input" value="1"
                            min="1">
                        <button type="button" class="quantity-btn increase">+</button>
                    </div>
                </div>

                {{-- السعر النهائي حسب الكمية --}}
                <div class="total-price">
                    المجموع: <span id="totalPrice">{{ number_format($finalPrice, 2) }} ريال</span>
                </div>

                <div class="add-to-bag-container">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        {{-- 🟢 لاحظ: ما في hidden للكمية، حنرسل input المباشر --}}
                        <input type="number" name="quantity" id="formQuantity" value="1" hidden>
                        <button class="add-to-bag">أضف إلى الحقيبة</button>
                    </form>
                </div>
            </div>

        </div>

        <!-- You May Also Like -->
        <!-- قد يعجبك أيضاً -->
        <div class="section-text">قد يعجبك أيضاً</div>

        <div class="carousel">
            <div class="carousel-buttons">
                <div class="carousel-button">‹</div>
                <div class="carousel-button">›</div>
            </div>

            @foreach ($relatedProducts as $item)
                <div class="carousel-item">
                    <div class="product-item">
                        <div class="quick-view">🔍</div>
                        <div class="heart-icon"><i class="far fa-heart"></i></div>

                        {{-- صورة المنتج --}}
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('assets/default.png') }}"
                            alt="{{ $item->name }}" loading="lazy" class="product-image">

                        {{-- تفاصيل المنتج --}}
                        <div class="product-details">
                            <div class="brand-name">{{ $item->category->name ?? 'غير مصنف' }}</div>
                            <div class="product-name">{{ $item->name }}</div>
                            <div class="price">{{ number_format($item->price, 2) }} ريال</div>

                            @if ($item->sale_price)
                                <div class="original-price">{{ number_format($item->price, 2) }} ريال</div>
                                <div class="discount">
                                    خصم {{ round((1 - $item->sale_price / $item->price) * 100) }}%
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- More From Tommy Hilfiger -->
        <div class="section-text">المزيد من {{ $product->brand ?? 'غير محدد' }}</div>

        <div class="carousel">
            <div class="carousel-buttons">
                <div class="carousel-button">‹</div>
                <div class="carousel-button">›</div>
            </div>

            <div class="carousel-item">
                <div class="product-item">
                    <div class="quick-view">🔍</div>
                    <div class="heart-icon">
                        <i class="far fa-heart"></i>
                    </div>
                    <img src="{{ asset('assets/front/img/prod6.jpg') }}" alt="Product 1" loading="lazy"
                        class="product-image">
                    <div class="product-details">
                        <div class="brand-name">TOMMY HILFIGER</div>
                        <div class="product-name">TH Business Logo Duffel Bag in Nyl...</div>
                        <div class="price">1,000 SAR</div>
                        <div class="original-price">1,250 SAR</div>
                        <div class="discount">20% OFF</div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="product-item">
                    <div class="quick-view">🔍</div>
                    <div class="heart-icon">
                        <i class="far fa-heart"></i>
                    </div>
                    <img src="{{ asset('assets/front/img/prod7.jpg') }}" alt="Product 2" loading="lazy"
                        class="product-image">
                    <div class="product-details">
                        <div class="brand-name">TOMMY HILFIGER</div>
                        <div class="product-name">Colour-blocked Beach Tote Bag</div>
                        <div class="price">800 SAR</div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="product-item">
                    <div class="quick-view">🔍</div>
                    <div class="heart-icon">
                        <i class="far fa-heart"></i>
                    </div>
                    <img src="{{ asset('assets/front/img/prod8.jpg') }}" alt="Product 3" loading="lazy"
                        class="product-image">
                    <div class="product-details">
                        <div class="brand-name">TOMMY HILFIGER</div>
                        <div class="product-name">TH Monogram Crossbody Duffel Bag</div>
                        <div class="price">1,250 SAR</div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="product-item">
                    <div class="quick-view">🔍</div>
                    <div class="heart-icon">
                        <i class="far fa-heart"></i>
                    </div>
                    <img src="{{ asset('assets/front/img/prod9.jpg') }}" alt="Product 4" loading="lazy"
                        class="product-image">
                    <div class="product-details">
                        <div class="brand-name">TOMMY HILFIGER</div>
                        <div class="product-name">TH Casual Prep Backpack in Leather</div>
                        <div class="price">2,150 SAR</div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="product-item">
                    <div class="quick-view">🔍</div>
                    <div class="heart-icon">
                        <i class="far fa-heart"></i>
                    </div>

                    <img src="{{ asset('assets/front/img/prod10.jpg') }}" alt="Product 5" loading="lazy"
                        class="product-image">
                    <div class="product-details">
                        <div class="brand-name">TOMMY HILFIGER</div>
                        <div class="product-name">Reporter Bag</div>
                        <div class="price">805 SAR</div>
                        <div class="original-price">1,150 SAR</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const unitPrice = parseFloat(document.getElementById("unitPrice").dataset.price);
        const qtyInput = document.getElementById("quantityInput");
        const totalPrice = document.getElementById("totalPrice");
        const formQuantity = document.getElementById("formQuantity");

        // تحديث السعر والمخفي للفورم
        function updateTotal() {
            const qty = parseInt(qtyInput.value) || 1;
            totalPrice.textContent = (unitPrice * qty).toFixed(2) + " ريال";
            formQuantity.value = qty; // يرسل القيمة الحقيقية للفورم
        }

        // أزرار + و -
        document.querySelector(".increase").addEventListener("click", function() {
            qtyInput.value = parseInt(qtyInput.value) + 1;
            updateTotal();
        });
        document.querySelector(".decrease").addEventListener("click", function() {
            if (qtyInput.value > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
                updateTotal();
            }
        });

        // تعديل يدوي
        qtyInput.addEventListener("input", updateTotal);

        updateTotal(); // تشغيل أول مرة
    });
</script>

    <script>
        document.querySelectorAll('.heart-icon').forEach(icon => {
            icon.addEventListener('click', () => {
                const heart = icon.querySelector("i");
                heart.classList.toggle("far");
                heart.classList.toggle("fas");
                icon.classList.toggle("active");
            });
        });
    </script>

    <script>
        // Animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.animate-fade-in');
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 200 * index);
            });

            // Add hover effects
            const productCards = document.querySelectorAll('.product-item');
            productCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                });
            });

            // Tab functionality
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                });
            });

            // Heart button toggle
            const heartButtons = document.querySelectorAll('.heart-button');
            heartButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const heartIcon = button.querySelector('svg');
                    if (heartIcon.getAttribute('fill') === 'currentColor') {
                        heartIcon.setAttribute('fill', 'none');
                    } else {
                        heartIcon.setAttribute('fill', 'currentColor');
                    }
                });
            });

            // Carousel navigation
            const carousels = document.querySelectorAll('.carousel');
            carousels.forEach(carousel => {
                const buttons = carousel.querySelectorAll('.carousel-button');
                const items = carousel.querySelectorAll('.carousel-item');

                let currentIndex = 0;

                buttons[0].addEventListener('click', () => {
                    currentIndex = Math.max(0, currentIndex - 1);
                    updateCarousel();
                });

                buttons[1].addEventListener('click', () => {
                    currentIndex = Math.min(items.length - 1, currentIndex + 1);
                    updateCarousel();
                });

                function updateCarousel() {
                    carousel.style.transform = `translateX(-${currentIndex * 250}px)`;
                }
            });

            // Add to bag animation
            const addToBagButton = document.querySelector('.add-to-bag');
            addToBagButton.addEventListener('click', () => {
                addToBagButton.style.backgroundColor = '#b36949';
                addToBagButton.innerHTML = '<i class="fas fa-check"></i> Added!';

                setTimeout(() => {
                    addToBagButton.style.backgroundColor = '#d37c5e';
                    addToBagButton.innerHTML = 'ADD TO BAG';
                }, 1500);
            });

            // Image gallery functionality
            const mainImage = document.querySelector('.main-image');
            const thumbnails = document.querySelectorAll('.thumbnail img');
            const imageControls = document.querySelectorAll('.image-control');

            // Array of thumbnail sources
            const imageSources = Array.from(thumbnails).map(img => img.src);

            // Set initial main image to first thumbnail
            if (imageSources.length > 0) {
                mainImage.src = imageSources[0];
            }

            let currentIndex = 0;

            // Thumbnail click to change main image
            thumbnails.forEach((thumbnail, index) => {
                thumbnail.addEventListener('click', () => {
                    mainImage.src = thumbnail.src;
                    currentIndex = index;
                });
            });

            // Arrow controls to navigate images
            imageControls[0].addEventListener('click', () => { // Left arrow ‹
                currentIndex = (currentIndex - 1 + imageSources.length) % imageSources.length;
                mainImage.src = imageSources[currentIndex];
            });

            imageControls[1].addEventListener('click', () => { // Right arrow ›
                currentIndex = (currentIndex + 1) % imageSources.length;
                mainImage.src = imageSources[currentIndex];
            });
        });
    </script>
@endsection
