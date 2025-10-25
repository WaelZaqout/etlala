@extends('front.master')

@section('content')
<main class="container new-arrivals-page">

    <!-- 🔹 Breadcrumb -->
    <div class="breadcrumb">
        <div class="container">
            <a href="{{ url('/') }}">الصفحة الرئيسية</a>
            <span>›</span>
            <span>حسابي</span>
        </div>
    </div>

    <!-- 🔹 صفحة الحساب -->
    <div class="container profile-page">
        @include('front.profile.sidebar')

        <!-- 🔸 المحتوى الرئيسي -->
        <div class="profile-main">
            <h1 class="profile-title">حسابي</h1>

            <!-- 🧾 الطلبات الأخيرة -->
            <div class="profile-section">
                <div class="section-title">
                    <span>طلبياتك الأخيرة</span>
                    <a href="{{ route('my.orders') }}">عرض كل الطلبات</a>
                </div>

            </div>

            <!-- 👤 المعلومات الشخصية -->
            <div class="profile-section">
                <div class="section-title">
                    <span>معلوماتك الشخصية</span>
                    <a href="#" id="toggle-personal">تعديل</a>
                </div>

                <div class="profile-info">
                    <div class="info-item"><span class="info-label">الاسم:</span><span class="info-value">{{ $u->name ?? 'غير محدد' }}</span></div>
                    <div class="info-item"><span class="info-label">البريد الإلكتروني:</span><span class="info-value">{{ $u->email ?? 'غير محدد' }}</span></div>
                    <div class="info-item"><span class="info-label">رقم الهاتف:</span><span class="info-value">{{ $u->phone ?? 'لم تتم الإضافة بعد' }}</span></div>
                    <div class="info-item"><span class="info-label">دفتر العناوين:</span><span class="info-value">{{ $u->address ?? 'لم تتم الإضافة بعد' }}</span></div>
                </div>

                <form id="personal-form" class="edit-form" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="{{ $u->name }}" placeholder="الاسم الكامل">
                    <input type="email" name="email" value="{{ $u->email }}" placeholder="البريد الإلكتروني">
                    <input type="text" name="phone" value="{{ $u->phone }}" placeholder="رقم الهاتف">
                    <input type="text" name="phone" value="{{ $u->address }}" placeholder="دفتر العناوين">
                    <div class="form-buttons">
                        <button type="submit" class="save-btn">💾 حفظ</button>
                        <button type="button" id="cancel-personal" class="cancel-btn">إلغاء</button>
                    </div>
                </form>
            </div>



            <!-- 💳 طريقة الدفع -->
            <div class="profile-section">
                <div class="section-title">
                    <span>طريقة الدفع المفضلة لديك</span>
                    <a href="#">تعديل بيانات الدفع</a>
                </div>
                <div class="order-history">
                    <div class="order-item">
                        <span>بطاقاتك</span>
                        <span class="order-status">0 بطاقة محفوظة</span>
                    </div>
                </div>
            </div>

            <!-- ⚙️ تفضيلات التواصل -->
            <div class="profile-section">
                <div class="section-title">
                    <span>تفضيلات التواصل</span>
                    <a href="#">تعديل طريقة التواصل المفضلة</a>
                </div>
                <div class="order-history">
                    <div class="order-item">لم يتم اختيار طريقة تواصل بعد</div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- 🌈 تنسيق CSS -->
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
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        padding: 30px;
    }

    .profile-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        border-bottom: 2px solid #f3f3f3;
        padding-bottom: 10px;
    }

    .profile-section {
        margin-bottom: 30px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .section-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: #444;
        margin-bottom: 15px;
    }

    .section-title a {
        font-size: 14px;
        color: #007bff;
        text-decoration: none;
        transition: 0.3s;
    }

    .section-title a:hover {
        text-decoration: underline;
    }

    .profile-info .info-item {
        display: flex;
        margin-bottom: 10px;
    }

    .info-label {
        width: 150px;
        font-weight: 600;
        color: #666;
    }

    .info-value {
        color: #333;
    }

    .edit-form {
        display: none;
        margin-top: 10px;
        background: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        animation: fadeIn 0.3s ease;
    }

    .edit-form input {
        display: block;
        width: 100%;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
    }

    .form-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .save-btn, .cancel-btn {
        padding: 8px 15px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .save-btn {
        background: #007bff;
        color: #fff;
    }

    .cancel-btn {
        background: #ccc;
        color: #333;
    }

    .save-btn:hover {
        background: #0056b3;
    }

    .cancel-btn:hover {
        background: #aaa;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .profile-page { flex-direction: column; }
        .profile-main { padding: 20px; }
    }
</style>

<script>
    function toggleForm(toggleBtnId, formId, cancelBtnId) {
        const toggleBtn = document.getElementById(toggleBtnId);
        const form = document.getElementById(formId);
        const cancelBtn = document.getElementById(cancelBtnId);

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            form.style.display = (form.style.display === 'block') ? 'none' : 'block';
        });

        cancelBtn.addEventListener('click', () => {
            form.style.display = 'none';
        });
    }

    toggleForm('toggle-personal', 'personal-form', 'cancel-personal');
    toggleForm('toggle-address', 'address-form', 'cancel-address');
</script>
@endsection
