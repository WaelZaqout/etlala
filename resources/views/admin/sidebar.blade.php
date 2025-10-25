<div class="nav-wrapper">
    <nav class="top-navbar">
        <div class="navbar-container">
            <ul class="navbar-nav">

                {{-- القسم الرئيسي --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-home me-1"></i> الرئيسية
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="">الرئيسية</a></li>
                        <li><a class="dropdown-item" href="">التحليلات</a></li>
                    </ul>
                </li>
                {{-- المتجر --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-store me-1"></i> المتجر
                    </a>
                    <ul class="dropdown-menu shadow text-end">
                        <li><a class="dropdown-item" href="{{route('categories.index')}}">الاقسام</a></li>
                        <li><a class="dropdown-item" href="{{route('products.index')}}">المنتجات</a></li>
                        <li><a class="dropdown-item" href="{{route('orders.index')}}">الطلبات</a></li>
                        <li><a class="dropdown-item" href="#">العملاء</a></li>
                    </ul>
                </li>

                {{-- إدارة المحتوى --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-newspaper me-1"></i> إدارة الصفحات
                    </a>
                </li>

                {{-- الرسائل --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-envelope me-1"></i> الرسائل
                    </a>
                    <ul class="dropdown-menu shadow text-end">
                        <li><a class="dropdown-item" href="">رسائل التواصل</a>
                        </li>
                        <li><a class="dropdown-item" href="">الكومنتات</a></li>
                    </ul>
                </li>

                {{-- المستخدمين --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-users me-1"></i> المستخدمين
                    </a>
                    <ul class="dropdown-menu shadow text-end">
                        <li><a class="dropdown-item" href="">إدارة المستخدمين</a>
                        </li>
                    </ul>
                </li>


                {{-- الإعدادات --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cogs me-1"></i> الإعدادات
                    </a>
                    <ul class="dropdown-menu shadow text-end">
                        <li><a class="dropdown-item" href="#">الإعدادات العامة</a></li>
                        <li><a class="dropdown-item" href="#">تعديل الإعدادات</a></li>
                        <li><a class="dropdown-item" href="#">النسخ الاحتياطي</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</div>
