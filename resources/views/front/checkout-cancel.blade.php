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
            background: #fef2f2
        }

        .status-hero .icon i {
            color: #dc2626;
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

        .tips {
            background: #f9fafb;
            border-radius: 12px;
            padding: 16px
        }

        .tips ul {
            margin: 0;
            padding-inline-start: 18px;
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
    </style>

    <div class="status-wrap">
        <div class="status-hero">
            <div class="icon"><i class="fas fa-times"></i></div>
            <h1>تم إلغاء العملية</h1>
        </div>
        <p class="lead">لم يكتمل الدفع. يمكنك المحاولة مرة أخرى أو اختيار الدفع عند الاستلام.</p>

        <div class="tips">
            <strong>تلميحات:</strong>
            <ul>
                <li>تأكد من إدخال بيانات البطاقة بصورة صحيحة.</li>
                <li>إن واجهت مشكلة، جرّب بطاقة مختلفة أو اختر الدفع عند الاستلام.</li>
            </ul>
        </div>

        <div class="actions">
            <a href="{{ route('checkout') }}" class="btnx btn-primary"><i class="fas fa-lock"></i> إعادة محاولة الدفع</a>
            <a href="{{ route('cart.index') }}" class="btnx btn-light"><i class="fas fa-shopping-cart"></i> العودة إلى
                السلة</a>
        </div>
    </div>
@endsection
