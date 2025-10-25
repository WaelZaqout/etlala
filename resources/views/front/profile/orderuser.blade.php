@extends('front.master')

@section('content')
    <main class="container new-arrivals-page py-5">

        <!-- 🔹 Breadcrumb -->
        <div class="breadcrumb mb-4">
            <div class="container d-flex align-items-center gap-2 text-muted">
                <a href="{{ url('/') }}" class="text-decoration-none text-dark fw-semibold">الصفحة الرئيسية</a>
                <span>›</span>
                <span>طلباتي</span>
            </div>
        </div>

        <!-- 🔹 صفحة الطلبات -->
        <div class="container profile-page">
            @include('front.profile.sidebar')

            <!-- 🔸 المحتوى الرئيسي -->
            <div class="profile-main">
                <h1 class="profile-title mb-4">طلبـــــاتي</h1>

                @if ($orders->isEmpty())
                    <div class="text-center py-5">
                        <img src="{{ asset('images/empty-orders.svg') }}" alt="لا يوجد طلبات" width="180" class="mb-3">
                        <p class="empty-text">ليس لديك أي طلبات حتى الآن.</p>
                    </div>
                @else
                    @foreach ($orders as $order)
                        <div class="order-item mb-4 p-4 rounded-4 shadow-sm bg-white border position-relative">

                            <!-- 🔸 رأس الطلب -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">طلب رقم #{{ $order->id }}</h5>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 ms-1"></i> {{ $order->created_at->format('Y-m-d') }}
                                    </small>
                                </div>
                                <span
                                    class="badge order-status
                                @if ($order->status == 'تم التوصيل') delivered
                                @elseif($order->status == 'ملغي') canceled
                                @else processing @endif">
                                    {{ $order->status ?? 'قيد المعالجة' }}
                                </span>
                            </div>

                            <!-- 🔸 المنتجات -->
                            <div class="order-products">
                                @foreach ($order->details as $detail)
                                    <div class="order-product d-flex align-items-center mb-3 pb-3 border-bottom">
                                        <img src="{{ asset('storage/' . $detail->product->image) }}"
                                            alt="{{ $detail->product->name }}" class="order-img me-3 rounded-3">
                                        <div class="flex-grow-1">
                                            <p class="fw-semibold mb-1">{{ $detail->product->name }}</p>
                                            <small class="text-muted">الكمية: {{ $detail->quantity }}</small>
                                        </div>
                                        <div class="fw-bold text-success">
                                            ${{ number_format($detail->price * $detail->quantity, 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- 🔸 الإجمالي -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <strong class="fs-6 text-dark">الإجمالي الكلي:</strong>
                                <span class="text-success fw-bold fs-5">${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>

    <!-- 🌈 تصميم CSS -->
    <style>
        .profile-page {
            display: flex;
            gap: 30px;
            margin-top: 30px;
            font-family: "Cairo", sans-serif;
        }

        .profile-main {
            flex: 1;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 35px;
        }

        .profile-title {
            font-size: 28px;
            font-weight: 800;
            color: #222;
            border-bottom: 3px solid #f5f5f5;
            padding-bottom: 10px;
        }

        .empty-text {
            color: #777;
            font-size: 16px;
        }

        .order-item {
            border: 1px solid #f1f1f1;
            transition: all 0.3s ease;
        }

        .order-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
        }

        .order-img {
            width: 85px;
            height: 85px;
            object-fit: cover;
        }

        .order-status {
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .order-status.processing {
            background-color: #e7f1ff;
            color: #0d6efd;
        }

        .order-status.delivered {
            background-color: #d1f3d1;
            color: #137c13;
        }

        .order-status.canceled {
            background-color: #f8d7da;
            color: #b02a37;
        }

        .order-product:last-child {
            border-bottom: none !important;
        }

        @media (max-width: 768px) {
            .profile-page {
                flex-direction: column;
            }

            .profile-main {
                padding: 20px;
            }

            .order-img {
                width: 70px;
                height: 70px;
            }
        }
    </style>
@endsection
