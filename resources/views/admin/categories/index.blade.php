@extends('admin.master')
@section('content')
@section('title', 'إدارة الأقسام')


<div class="container">

    {{-- Header + إحصائيات + زر إضافة --}}
    <div class="header">
        <div class="search-bar mb-3">
            <input id="searchByName" type="text" placeholder="الاسم" class="form-control" value="{{ $q ?? '' }}">

        </div>

        <a href="{{ route('categories.create') }}" class="add-button">
            <i class="fas fa-plus"></i> إضافة قسم
        </a>
    </div>
    <div class="table-container">
        <table class="table category-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>صورة القسم</th>
                    <th>الاسم</th>
                    <th>القسم الاب</th>
                    <th>الرابط المختصر</th>
                    <th>الوصف</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="categoriesTbody">
                @include('admin.categories._rows', ['categories' => $categories])
            </tbody>

            <div id="categoriesPagination" class="mt-3">
                {{-- {{ $categories->links() }} --}}
            </div>

        </table>
    </div>

</div>



@include('admin.categories._form')

<script>
    // عناصر المودال والحقول
    const modalOverlay = document.getElementById('modalOverlay');
    const modalTitle   = document.getElementById('modalTitle');
    const categoryForm = document.getElementById('categoryForm');
    const methodSpoof  = document.getElementById('methodSpoof');

    const openModalBtn = document.querySelector('.add-button');
    const closeModalBtn= document.getElementById('closeModalBtn');
    const cancelBtn    = document.getElementById('cancelBtn');
    const saveBtn      = document.getElementById('saveBtn');

    const nameInput    = document.getElementById('name');
    const descInput    = document.getElementById('editor'); // textarea للوصف
    const imagePreview = document.getElementById('imagePreview');

    let currentCategoryId = null;

    // فتح المودال
    function openModal(editMode = false, data = null) {
        modalOverlay.classList.add('active');

        if (editMode && data) {
            modalTitle.textContent = 'تعديل القسم';
            currentCategoryId = data.id;

            nameInput.value = data.name || '';

            // الوصف
            if (window.CKEDITOR && CKEDITOR.instances.editor) {
                CKEDITOR.instances.editor.setData(data.description || '');
            } else {
                descInput.value = data.description || '';
            }

            // الفورم -> Update
            categoryForm.action = data.updateUrl;
            methodSpoof.value = 'PUT';

            // صورة
            if (imagePreview) {
                imagePreview.src = data.image ? `/storage/${data.image}` : '';
                imagePreview.style.display = data.image ? 'block' : 'none';
            }
        } else {
            modalTitle.textContent = 'إضافة قسم جديد';
            currentCategoryId = null;

            categoryForm.reset();

            if (window.CKEDITOR && CKEDITOR.instances.editor) {
                CKEDITOR.instances.editor.setData('');
            } else {
                descInput.value = '';
            }

            categoryForm.action = "{{ route('categories.store') }}";
            methodSpoof.value = '';

            if (imagePreview) {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }
        }
    }

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
            name: btn.dataset.name,
            description: btn.dataset.description || '',
            image: btn.dataset.image,
            updateUrl: btn.dataset.updateUrl
        };

        openModal(true, data);
    });

    // إغلاق
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) closeModal();
    });

    // حفظ
    saveBtn.addEventListener('click', (e) => {
        e.preventDefault();

        if (window.CKEDITOR && CKEDITOR.instances.editor) {
            CKEDITOR.instances.editor.updateElement();
        }

        if (categoryForm.checkValidity()) {
            categoryForm.submit();
        } else {
            categoryForm.reportValidity();
        }
    });
</script>


<script>
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];

        $.ajax({
            url: '?page=' + page,
            success: function(data) {
                $('#tableData').html(data);
            }
        });
    });
</script>
<script>
    (function() {
        const input = document.getElementById('searchByName');
        const tbody = document.getElementById('categoriesTbody');
        const pagerBox = document.getElementById('categoriesPagination');
        const baseIndex = "{{ route('categories.index') }}";

        let timer = null;

        function runSearch(url) {
            const finalUrl = new URL(url || baseIndex, window.location.origin);
            // ضمّن قيمة البحث الحالية في الرابط
            const q = (input?.value || '').trim();
            if (q !== '') finalUrl.searchParams.set('q', q);
            else finalUrl.searchParams.delete('q');

            // حالة تحميل بسيطة
            if (input) input.disabled = true;

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
                    }
                    // حدّث شريط العنوان بدون إعادة تحميل
                    if (window.history && window.history.replaceState) {
                        window.history.replaceState({}, '', finalUrl.toString());
                    }
                })
                .catch(() => {
                    // تقدر تعرض Toast خطأ هنا لو عندك util
                    console.error('Search failed');
                })
                .finally(() => {
                    if (input) input.disabled = false;
                });
        }

        // Debounce on input
        if (input) {
            input.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => runSearch(baseIndex), 300);
            });
        }

        // AJAX pagination (تفويض أحداث)
        document.addEventListener('click', function(e) {
            const a = e.target.closest('#categoriesPagination a');
            if (!a) return;
            e.preventDefault();
            runSearch(a.href);
        });


    })();
</script>

@section('js')
@endsection
@endsection
