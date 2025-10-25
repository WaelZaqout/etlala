@extends('front.master')

@section('content')
    <style>
        .status-wrap {
            max-width: 820px;
            margin: 40px auto;
            padding: 24px;
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow)
        }

        .status-hero {
            display: flex;
            align-items: center;
            gap: 16px;
            justify-content: center;
            margin-bottom: 10px
        }

        .status-hero .icon {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8f5e9
        }

        .status-hero .icon i {
            color: #16a34a;
            font-size: 26px
        }

        h1 {
            font-size: 1.8rem;
            text-align: center;
            margin: 0 0 8px
        }

        .lead {
            color: #4b5563;
            text-align: center;
            margin-bottom: 14px
        }

        .card {
            background: #f9fafb;
            border-radius: 12px;
            padding: 16px
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        .kv {
            display: flex;
            justify-content: space-between;
            padding: 10px 12px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #eef2f7
        }

        .kv span:first-child {
            color: #6b7280
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-top: 18px
        }

        .btnx {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: var(--shadow);
            transition: .2s
        }

        .btn-primary {
            background: #a87054;
            color: #fff
        }

        .btn-primary:hover {
            background: #8d5d44;
            transform: translateY(-2px)
        }

        .btn-light {
            background: #eeeeef;
            color: #333
        }

        .btn-light:hover {
            background: #e5e7eb;
            transform: translateY(-2px)
        }

        .notice {
            margin-top: 12px;
            color: #64748b;
            text-align: center;
            font-size: .95rem
        }
    </style>

    <div class="status-wrap">
        <div class="status-hero">
            <div class="icon"><i class="fas fa-check"></i></div>
            <h1>تمت العملية بنجاح 🎉</h1>
        </div>
        <p class="lead">شكراً لطلبك! تم استلام الدفع بنجاح. ستصلك تفاصيل الطلب عبر البريد الإلكتروني.</p>

        <div class="card">
            <div class="row">
                <div class="kv"><span>رقم الطلب</span><span>{{ $order->id ?? '—' }}</span></div>
                <div class="kv"><span>قيمة
                        الطلب</span><span>{{ isset($order) ? number_format($order->total_price, 2) : number_format($total ?? 0, 2) }}
                        {{ $currencyLabel ?? 'ر.س' }}</span></div>
                <div class="kv"><span>حالة الدفع</span><span>{{ $order->payment_status ?? 'paid' }}</span></div>
                <div class="kv"><span>طريقة الدفع</span><span>{{ $order->payment_method ?? 'stripe' }}</span></div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('my.orders') }}" class="btnx btn-primary"><i class="fas fa-receipt"></i> مشاهدة طلباتي</a>
            <a href="{{ route('new') }}" class="btnx btn-light"><i class="fas fa-shopping-bag"></i> العودة للتسوق</a>
        </div>

        <p class="notice">
            ملاحظة: في حال لم يظهر رقم الطلب، فذلك يعني أن الصفحة عُرضت قبل وصول تأكيد الدفع من Stripe.
            التحديث يتم تلقائياً عبر Webhook.
        </p>
    </div>
@endsection
