<!DOCTYPE html>
<html>

<head>
    <title>Buy cool new product</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <script src="https://js.stripe.com/clover/stripe.js"></script>
</head>
<style>
    /* ================== Root & Theme ================== */
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

    :root {
        --bg-1: #0b1220;
        --bg-2: #0f172a;
        --card: rgba(255, 255, 255, 0.08);
        --card-border: rgba(255, 255, 255, 0.18);
        --text: #e5e7eb;
        --muted: #94a3b8;
        --brand-1: #06b6d4;
        /* cyan-500 */
        --brand-2: #3b82f6;
        /* blue-500 */
        --brand-3: #8b5cf6;
        /* violet-500 */
        --ring: rgba(59, 130, 246, .35);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html,
    body {
        height: 100%;
    }

    body {
        font-family: "Cairo", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        color: var(--text);
        background:
            radial-gradient(1200px 700px at 10% -10%, #1e293b 0%, transparent 45%),
            radial-gradient(1000px 600px at 90% 0%, #111827 0%, transparent 50%),
            linear-gradient(180deg, var(--bg-1), var(--bg-2));
        display: grid;
        place-items: center;
        padding: 28px;
        overflow-x: hidden;
    }

    /* خلفيّات زخرفية لطيفة */
    body::before,
    body::after {
        content: "";
        position: fixed;
        z-index: -1;
        filter: blur(70px);
        opacity: .55;
    }

    body::before {
        width: 520px;
        height: 520px;
        border-radius: 50%;
        top: -120px;
        left: -80px;
        background: conic-gradient(from 30deg,
                #22d3ee, #60a5fa, #a78bfa, #22d3ee);
    }

    body::after {
        width: 620px;
        height: 420px;
        border-radius: 50%;
        bottom: -140px;
        right: -120px;
        background: conic-gradient(from -60deg,
                #0ea5e9, #6366f1, #06b6d4, #0ea5e9);
    }

    /* ================== Section / Card ================== */
    section {
        width: min(940px, 96vw);
        background: var(--card);
        backdrop-filter: blur(16px) saturate(140%);
        -webkit-backdrop-filter: blur(16px) saturate(140%);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 28px;
        box-shadow:
            0 30px 80px rgba(0, 0, 0, .35),
            inset 0 1px 0 rgba(255, 255, 255, .06);
        display: grid;
        gap: 26px;
        position: relative;
    }

    /* شريط علوي صغير للثقة */
    section::before {
        content: "دفع آمن عبر Stripe";
        position: absolute;
        top: 14px;
        right: 18px;
        font-size: .85rem;
        letter-spacing: .3px;
        color: #cbd5e1;
        background: rgba(148, 163, 184, .14);
        border: 1px solid rgba(148, 163, 184, .2);
        padding: 6px 10px;
        border-radius: 999px;
    }

    /* ================== Product ================== */
    .product {
        display: grid;
        gap: 24px;
        align-items: center;
        grid-template-columns: 260px 1fr;
    }

    .product img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, .12);
        box-shadow: 0 16px 40px rgba(2, 6, 23, .45);
        transform: translateZ(0);
    }

    .description h3 {
        font-weight: 800;
        font-size: 1.7rem;
        letter-spacing: .2px;
        margin-bottom: 10px;
    }

    .description h5 {
        font-weight: 800;
        font-size: 1.35rem;
        background: linear-gradient(90deg, var(--brand-1), var(--brand-2), var(--brand-3));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* شريحة مميزات جميلة (تظهر تلقائيًا بدون تعديل HTML) */
    .description::after {
        content: "نسخة رقمية • تحديثات مجانية • تسليم فوري";
        display: block;
        margin-top: 12px;
        color: var(--muted);
        font-size: .95rem;
        line-height: 1.6;
    }

    /* ================== Checkout Button ================== */
    form {
        margin-top: 8px;
    }

    #checkout-button {
        position: relative;
        overflow: hidden;
        border: 0;
        cursor: pointer;
        padding: 16px 22px;
        border-radius: 16px;
        font-weight: 800;
        font-size: 1.05rem;
        letter-spacing: .3px;
        color: white;
        background:
            linear-gradient(135deg, var(--brand-1), var(--brand-2) 50%, var(--brand-3));
        box-shadow:
            0 16px 28px rgba(59, 130, 246, .35),
            inset 0 1px 0 rgba(255, 255, 255, .35);
        transition: transform .18s ease, box-shadow .25s ease, filter .25s ease;
    }

    #checkout-button::before {
        /* لمعة متحركة */
        content: "";
        position: absolute;
        inset: -1px;
        background: linear-gradient(120deg, rgba(255, 255, 255, .18), transparent 40%, rgba(255, 255, 255, .12));
        transform: translateX(-100%);
        transition: transform .8s ease;
    }

    #checkout-button:hover {
        transform: translateY(-2px);
        filter: saturate(1.1) contrast(1.02);
    }

    #checkout-button:hover::before {
        transform: translateX(0);
    }

    #checkout-button:active {
        transform: translateY(0);
    }

    #checkout-button:focus-visible {
        outline: none;
        box-shadow:
            0 0 0 5px var(--ring),
            0 16px 28px rgba(59, 130, 246, .35);
    }

    /* أيقونات ثقة صغيرة تحت الزر (نضيفها تلقائيًا) */
    form::after {
        content: "مدعوم بواسطة Stripe • تشفير قياسي • لا نحتفظ ببيانات بطاقتك";
        display: block;
        margin-top: 10px;
        font-size: .86rem;
        color: #a1a1aa;
    }

    /* ================== Helpers ================== */
    .helper {
        font-size: .95rem;
        color: #cbd5e1;
        line-height: 1.7;
        background: rgba(148, 163, 184, .08);
        border: 1px solid rgba(148, 163, 184, .18);
        padding: 12px 14px;
        border-radius: 12px;
        margin-top: 4px;
    }

    /* ================== Responsive ================== */
    @media (max-width: 860px) {
        .product {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .product img {
            margin: 0 auto;
            height: 260px;
            max-width: 78%;
        }

        section {
            padding: 22px;
        }

        .description h3 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 460px) {
        .product img {
            height: 220px;
            max-width: 92%;
        }

        #checkout-button {
            width: 100%;
        }

        section::before {
            display: none;
        }
    }

    /* ================== RTL support (اختياري) ================== */
    html[dir="rtl"] body {
        direction: rtl;
    }

    html[dir="rtl"] section::before {
        left: 18px;
        right: auto;
    }

    html[dir="rtl"] .product {
        text-align: start;
    }

    /* ====== Base & Typography ====== */
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html,
    body {
        height: 100%;
    }

    body {
        font-family: "Cairo", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        color: #0f172a;
        /* نص داكن مريح */
        background: #f8fafc;
        /* خلفية عادية فاتحة */
        display: grid;
        place-items: center;
        padding: 24px;
    }

    /* ====== Card / Section ====== */
    section {
        width: 100%;
        max-width: 760px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        /* إطار خفيف */
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        /* ظل بسيط */
        padding: 24px;
        display: grid;
        gap: 20px;
    }

    /* ====== Product Block ====== */
    .product {
        display: grid;
        grid-template-columns: 160px 1fr;
        gap: 16px;
        align-items: center;
    }

    .product img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #eef2f7;
    }

    .description h3 {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 6px;
    }

    .description h5 {
        font-weight: 700;
        font-size: 1.05rem;
        color: #0ea5e9;
        /* لمسة لونية بسيطة */
    }

    /* ====== Button ====== */
    form {
        margin-top: 4px;
    }

    #checkout-button {
        border: 0;
        border-radius: 10px;
        padding: 12px 16px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        color: #ffffff;
        background: #2563eb;
        /* أزرق واضح */
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.22);
        transition: transform .12s ease, box-shadow .2s ease, opacity .2s ease;
    }

    #checkout-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(37, 99, 235, 0.24);
    }

    #checkout-button:active {
        transform: translateY(0);
    }

    #checkout-button:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    /* ====== Helper text (اختياري لو أضفته) ====== */
    .helper {
        font-size: .92rem;
        color: #475569;
        line-height: 1.6;
    }

    /* ====== Responsive ====== */
    @media (max-width: 620px) {
        section {
            padding: 20px;
            border-radius: 12px;
        }

        .product {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .product img {
            margin: 0 auto;
            height: 200px;
        }
    }

    /* ====== RTL (اختياري) ====== */
    html[dir="rtl"] body {
        direction: rtl;
    }
</style>

<body>
    <section>

        @if (isset($cartRows) && $cartRows->count())
            @php
                $first = $cartRows->first();
                $product = $first->product ?? null;
            @endphp
            <div class="product">
                <img src="{{ asset('storage/' . ($product->image ?? 'assets/front/img/brand.jpg')) }}"
                    alt="{{ $product->name ?? 'منتج' }}" class="product-image">
                <div class="description">
                    <h3>{{ $product->name ?? 'منتج' }}</h3>
                    <h5>الإجمالي: {{ number_format($total ?? 0, 2) }} ر.س</h5>
                </div>
            </div>
        @else
            <div class="product">
                <img src="{{ asset('assets/front/img/brand.jpg') }}" alt="منتج افتراضي" class="product-image">
                <div class="description">
                    <h3>لا توجد منتجات</h3>
                    <h5>الإجمالي: 0.00 ر.س</h5>
                </div>
            </div>
        @endif

        @if (isset($cartRows) && $cartRows->count())
            <div class="helper">
                <ul>
                    @foreach ($cartRows as $row)
                        <li>{{ $row->product->name ?? 'منتج مفقود' }} × {{ $row->quantity }} —
                            {{ number_format(($row->product->sale_price && $row->product->sale_price > 0 ? $row->product->sale_price : $row->product->price) * $row->quantity, 2) }}
                            ر.س</li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="helper">السلة فارغة</div>
        @endif
        <form action="{{ route('checkout.create') }}" method="POST">
            @csrf
            <button type="submit" id="checkout-button">تابع للدفع</button>
        </form>
    </section>
</body>

</html>
