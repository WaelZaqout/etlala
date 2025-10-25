@extends('front.master')

@section('content')
    <main class="container new-arrivals-page">

        <div class="breadcrumb">
            <div class="container">
                <a href="{{ url('/') }}">الصفحة الرئيسية</a>
                <span>›</span>
                <span>إعدادات الحساب</span>
            </div>
        </div>

        <div class="container profile-page">
            @include('front.profile.sidebar')

            <div class="profile-main">
                <div class="settings-header">
                    <h2 class="settings-title"><i class="fas fa-cog"></i> إعدادات الحساب</h2>
                    <p class="settings-subtitle">قم بتحديث معلومات حسابك بسهولة</p>
                </div>

                @if (session('success'))
                    <div class="settings-alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{route('settings.update')}}" method="POST" enctype="multipart/form-data" class="settings-form">

                    @method('PUT')
                    @csrf

                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-user"></i> معلومات شخصية</h3>

                        <div class="form-group">
                            <label for="name" class="form-label"><i class="fas fa-user"></i> الاسم الكامل</label>
                            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $u->name) }}" >
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label"><i class="fas fa-phone"></i> رقم الهاتف</label>
                            <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $u->phone) }}" >
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label"><i class="fas fa-map-marker-alt"></i> العنوان</label>
                            <input type="text" id="address" name="address" class="form-input" value="{{ old('address', $u->address) }}" >
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-camera"></i> صورة الحساب</h3>

                        <div class="form-group">
                            <label for="avatar" class="form-label"><i class="fas fa-upload"></i> اختر صورة جديدة</label>
                            <input type="file" id="avatar" name="avatar" class="form-input" accept="image/*">
                            @if ($u->avatar)
                                <div class="avatar-preview">
                                    <img src="{{ asset('storage/' . $u->avatar) }}" alt="Avatar" class="avatar-img">
                                    <p class="avatar-note">انقر على الصورة لتغييرها</p>
                                </div>
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user-circle"></i>
                                    <p>لم يتم تحميل صورة بعد</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-lock"></i> تغيير كلمة المرور</h3>

                        <div class="form-group">
                            <label for="password" class="form-label"><i class="fas fa-key"></i> كلمة المرور الجديدة (اختياري)</label>
                            <input type="password" id="password" name="password" class="form-input" placeholder="أدخل كلمة مرور جديدة">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label"><i class="fas fa-key"></i> تأكيد كلمة المرور</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="أعد إدخال كلمة المرور">
                        </div>
                    </div>

                    <button type="submit" class="btn-update"><i class="fas fa-save"></i> تحديث الحساب</button>
                </form>
            </div>
        </div>
    </main>

    <style>
        .settings-header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 2rem 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .settings-title {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .settings-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
        }

        .settings-alert {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            color: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(86, 171, 47, 0.3);
            animation: slideIn 0.5s ease-out;
        }

        .settings-form {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid #f0f0f0;
        }

        .form-section {
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid #007bff;
        }

        .section-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            color: #555;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background: #fff;
        }

        .form-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
            transform: translateY(-2px);
        }

        .avatar-preview {
            margin-top: 1rem;
            text-align: center;
        }

        .avatar-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .avatar-img:hover {
            transform: scale(1.05);
        }

        .avatar-note {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .avatar-placeholder {
            text-align: center;
            padding: 2rem;
            color: #999;
        }

        .avatar-placeholder i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .btn-update {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .settings-form {
                padding: 2rem 1.5rem;
            }

            .settings-title {
                font-size: 2rem;
            }

            .settings-header {
                padding: 1.5rem 1rem;
            }

            .form-section {
                padding: 1rem;
            }

            .avatar-img {
                width: 100px;
                height: 100px;
            }
        }
    </style>
@endsection
