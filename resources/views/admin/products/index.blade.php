@extends('admin.master')
@section('content')
@section('title', 'إدارة الأقسام')


<div class="container">

    {{-- Header + إحصائيات + زر إضافة --}}
    <div class="header">
        <div class="search-bar mb-3">
            <input id="searchByName" type="text" placeholder="الاسم" class="form-control" value="{{ $q ?? '' }}">
        </div>

        <a href="#" class="add-button">
            <i class="fas fa-plus"></i> إضافة منتج
        </a>
    </div>
    <div class="table-container">
        <table class="table product-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>صورة المنتج</th>
                    <th>اسم المنتج</th>
                    <th>اسم القسم</th>
                    <th>وصف المنتج</th>
                    <th>سعر المنتج</th>
                    {{-- <th>سعر التخفيض</th> --}}
                    {{-- <th>الكمية/المخزةن</th> --}}
                    {{-- <th>الرابط المختصر</th> --}}
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="categoriesTbody">
                @include('admin.products._rows', ['products' => $products])
            </tbody>
        </table>

        <div id="categoriesPagination" class="mt-3">
            @include('admin.products._pagination', ['products' => $products])
        </div>
    </div>

</div>



@include('admin.products._form')

<script>
    // عناصر المودال والحقول
    const modalOverlay = document.getElementById('modalOverlay');
    const modalTitle = document.getElementById('modalTitle');
    const categoryForm = document.getElementById('categoryForm');
    const methodSpoof = document.getElementById('methodSpoof');

    const openModalBtn = document.querySelector('.add-button');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const saveBtn = document.getElementById('saveBtn');

    const nameInput = document.getElementById('name');
    const descInput = document.getElementById('description');
    const imagePreview = document.getElementById('imagePreview');
    const categorySelect = document.getElementById('category_id');

    let currentProductId = null;

    // فتح المودال
    function openModal(editMode = false, data = null) {
        modalOverlay.classList.add('active');

        if (editMode && data) {
            modalTitle.textContent = 'تعديل المنتج';
            currentProductId = data.id;

            nameInput.value = data.name || '';
            descInput.value = data.description || '';
            categorySelect.value = data.category_id || '';
            const priceInput = document.getElementById('price');
            if (priceInput) priceInput.value = data.price || 0;
            // const salePriceInput = document.getElementById('sale_price');
            // if (salePriceInput) salePriceInput.value = data.sale_price || 0;
            // const stockInput = document.getElementById('stock');
            // if (stockInput) stockInput.value = data.stock || 0;

            if (imagePreview) {
                imagePreview.src = data.image ? `/storage/${data.image}` : '';
                imagePreview.style.display = data.image ? 'block' : 'none';
            }

            categoryForm.setAttribute("action", data.updateUrl);
            methodSpoof.value = 'PUT';

        } else {
            modalTitle.textContent = 'إضافة منتج جديد';
            currentProductId = null;

            categoryForm.reset();
            categoryForm.action = "{{ route('products.store') }}";
            methodSpoof.value = '';

            categorySelect.value = '';
            const priceInputAdd = document.getElementById('price');
            if (priceInputAdd) priceInputAdd.value = '';
            // const salePriceInputAdd = document.getElementById('sale_price');
            // if (salePriceInputAdd) salePriceInputAdd.value = '';
            // const stockInputAdd = document.getElementById('stock');
            // if (stockInputAdd) stockInputAdd.value = '';

            if (imagePreview) {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }
        }
    }

    // إغلاق المودال
    function closeModal() {
        modalOverlay.classList.remove('active');
    }

    // زر إضافة
    if (openModalBtn) {
        openModalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(false, null);
        });
    }

    // زر تعديل
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.edit-btn');
        if (!btn) return;

        e.preventDefault();
        const data = {
            id: btn.dataset.id,
            category_id: btn.dataset.category,
            name: btn.dataset.name,
            description: btn.dataset.description || '',
            price: btn.dataset.price || 0,
            sale_price: btn.dataset.salePrice || 0,
            stock: btn.dataset.stock || 0,
            image: btn.dataset.image || '',
            updateUrl: btn.dataset.updateUrl
        };

        openModal(true, data);
    });

    // إغلاق المودال عند الضغط على زر أو الخلفية
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) closeModal();
    });

    // حفظ البيانات
    saveBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (categoryForm.checkValidity()) {
            categoryForm.submit();
        } else {
            categoryForm.reportValidity();
        }
    });
</script>



<script>
    (function() {
        const input = document.getElementById('searchByName');
        const tbody = document.getElementById('categoriesTbody');
        const pagerBox = document.getElementById('categoriesPagination');
        const baseIndex = "{{ route('products.index') }}";

        let timer = null;

        function runSearch(url) {
            const finalUrl = new URL(url || baseIndex, window.location.origin);
            const q = (input?.value || '').trim();
            if (q !== '') finalUrl.searchParams.set('q', q);
            else finalUrl.searchParams.delete('q');

            if (input) input.disabled = true;
            tbody.innerHTML = '<tr><td colspan="7" class="text-center"><i class="fas fa-spinner fa-spin"></i> جاري التحميل...</td></tr>';

            fetch(finalUrl.toString(), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (tbody && data.rows !== undefined) {
                        tbody.innerHTML = data.rows;
                    }
                    if (pagerBox && data.pagination !== undefined) {
                        pagerBox.innerHTML = data.pagination;
                        bindPaginationLinks();
                    }
                    if (window.history && window.history.replaceState) {
                        window.history.replaceState({}, '', finalUrl.toString());
                    }
                })
                .catch(() => {
                    tbody.innerHTML =
                        '<tr><td colspan="7" class="text-center text-danger">حدث خطأ أثناء التحميل</td></tr>';
                })
                .finally(() => {
                    if (input) input.disabled = false;
                });
        }

        function bindPaginationLinks() {
            const links = document.querySelectorAll('#categoriesPagination a.page-link');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    runSearch(this.href);
                });
            });
        }

        if (input) {
            input.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => runSearch(baseIndex), 300);
            });
        }

        bindPaginationLinks();
    })();
</script>

@section('js')
@endsection
@endsection
