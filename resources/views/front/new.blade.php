@extends('front.master')
@section('content')
    <!-- Main Content -->
    <main class="container new-arrivals-page">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <span>نساء</span>
            <span class="separator">›</span>
            <span>ما وصل حديثا</span>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 30px;">
            <!-- Filter Sidebar -->


            <!-- Product Grid -->
            <div style="flex: 1; min-width: 300px;">

                <div class="results-header">
                    <h1>ما وصل حديثا</h1>
                    <div class="results-controls">
                        <div class="results-count">عرض 8 من 8</div>
                        <div class="per-page">
                            <span>عرض:</span>
                            <select>
                                <option>8 لكل صفحة</option>
                                <option>12 لكل صفحة</option>
                                <option>24 لكل صفحة</option>
                                <option>36 لكل صفحة</option>
                            </select>
                        </div>
                        <div class="sort-by">
                            <span>ترتيب حسب:</span>
                            <select>
                                <option>الأحدث</option>
                                <option>السعر: من الأقل إلى الأعلى</option>
                                <option>السعر: من الأعلى إلى الأقل</option>
                                <option>الأكثر مبيعاً</option>
                            </select>
                        </div>
                        <div class="view-switcher">
                            <button data-cols="2" class="icon-lines lines-2"></button>
                            <button data-cols="3" class="icon-lines lines-3"></button>
                            <button data-cols="4" class="icon-lines lines-4"></button>
                            <button data-cols="5" class="icon-lines lines-5"></button>
                            <button data-cols="6" class="icon-lines lines-6"></button>
                        </div>

                    </div>
                </div>


                <div class="product-grid">
                    @foreach ($products as $product)
                        <!-- Product 1 -->
                        <a href="{{ route('products.show', $product->id) }}" class="product-card">
                            <div class="product-actions">
                                <button class="product-action-btn"><i class="fas fa-truck"></i></button>
                            </div>
                            <div class="product-favorite"><i class="far fa-heart"></i></div>
                            <div class="quick-view"><i class="far fa-eye"></i></div>
                            <div class="product-img-container">
                                {{-- الصورة الرئيسية --}}
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/default.png') }}"
                                    alt="{{ $product->name }}" loading="lazy" class="product-img">

                                {{-- أول صورة من المعرض كصورة بديلة --}}
                                @if ($product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                        alt="{{ $product->name }}" loading="lazy" class="product-img product-img-alt">
                                @endif
                            </div>

                            <div class="product-info">
                                <div class="badge-container">
                                    <div class="exclusive-badge">حصري</div>
                                    <div class="new-badge">جديد</div>
                                </div>
                                <div class="product-brand">AMRI</div>
                                <div class="product-name"> {{ $product->name }} </div>
                                <div class="product-price">{{ $product->price }} </div>
                                <div class="product-colors">
                                    <div class="color-dot" style="background-color: #f5f5f5;" title="عاجي"></div>
                                    <div class="color-dot" style="background-color: #9b59b6;" title="بنفسجي"></div>
                                    <div class="color-dot" style="background-color: #e74c3c;" title="أحمر"></div>
                                </div>
                            </div>
                        </a>
                    @endforeach


                </div>
            </div>
        </div>
    </main>

    <div id="image-modal" class="image-modal">
        <div class="modal-overlay"></div>

        <!-- أزرار الأسهم خارج .modal-content -->
        <button class="modal-prev"><i class="fas fa-chevron-left"></i></button>
        <button class="modal-next"><i class="fas fa-chevron-right"></i></button>

        <div class="modal-content">
            <button class="modal-close">&times;</button>

            <!-- الصورة الرئيسية -->
            <div class="modal-main-image">
                <img id="modal-image" src="" alt="Product Image">
            </div>

            <!-- الصور المصغرة -->
            <div class="modal-thumbnails" id="modal-thumbnails"></div>
        </div>
    </div>
@endsection
