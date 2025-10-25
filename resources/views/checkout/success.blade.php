@extends('front.master')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('Home') }}">الصفحة الرئيسية</a>
        <span>&lt;</span>
        <span>نجاح الدفع</span>
    </div>

    <div class="main-container" style="max-width:900px;margin:24px auto;">
        <div style="background:var(--white);padding:24px;border-radius:12px;box-shadow:var(--shadow);">
            <h2 style="margin-bottom:8px;color:var(--dark);">تم الدفع بنجاح</h2>

            @if(empty($order))
                <p>لم يتم العثور على طلب مرتبط بهذه الجلسة (session_id = <strong>{{ $sessionId ?? '-' }}</strong>).</p>
                <p>إن كنت دخلت عبر رابط خاطئ، يمكنك مراجعة طلباتك من <a href="{{ route('my.orders') }}">صفحتي</a> أو العودة إلى <a href="{{ route('Home') }}">الصفحة الرئيسية</a>.</p>
            @else
                <p>رقم الطلب: <strong>#{{ $order->id }}</strong></p>
                <p>معرف جلسة الدفع (Stripe): <strong>{{ $order->stripe_session_id }}</strong></p>
                <p>الإجمالي المدفوع: <strong>{{ number_format($order->total_price, 2) }} ر.س</strong></p>

                <h3 style="margin-top:18px;margin-bottom:8px;color:var(--dark);">تفاصيل الطلب</h3>
                <table style="width:100%;border-collapse:collapse;margin-top:8px;">
                    <thead>
                        <tr style="text-align:right;border-bottom:1px solid #e5e7eb;">
                            <th style="padding:10px">المنتج</th>
                            <th style="padding:10px">الكمية</th>
                            <th style="padding:10px">سعر الوحدة</th>
                            <th style="padding:10px">المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                            <tr style="text-align:right;border-bottom:1px solid #f3f4f6;">
                                <td style="padding:10px">{{ $detail->product->name ?? 'منتج محذوف' }}</td>
                                <td style="padding:10px">{{ $detail->quantity }}</td>
                                <td style="padding:10px">{{ number_format($detail->price, 2) }} ر.س</td>
                                <td style="padding:10px">{{ number_format($detail->price * $detail->quantity, 2) }} ر.س</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:18px;display:flex;gap:12px;justify-content:flex-end;">
                    <a href="{{ route('my.orders') }}" class="back-btn" style="padding:10px 16px;border-radius:8px;text-decoration:none;background:#a87054;color:#fff;">عرض جميع الطلبات</a>
                    <a href="{{ route('Home') }}" class="back-btn" style="padding:10px 16px;border-radius:8px;text-decoration:none;background:#aaa;color:#222;">العودة للمتجر</a>
                </div>
            @endif
        </div>
    </div>

@endsection
