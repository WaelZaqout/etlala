<!-- Responsive Modal -->
<div id="modalOverlay" class="modal-overlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title">إضافة قسم جديد</h3>
            <button id="closeModalBtn" class="close-btn">&times;</button>
        </div>

        <div class="modal-body">
            {{-- ملاحظة: سيُستبدل الـaction و _method ديناميكياً عند التعديل --}}
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                @csrf
                <input type="hidden" id="methodSpoof" name="_method" value=""> {{-- 'PUT' عند التعديل --}}
                <input type="hidden" id="formAction" value="{{ route('products.store') }}"> {{-- للتبديل JS --}}

                <div class="form-grid">
                    {{-- الاسم --}}
                    <div class="form-group full-width">
                        <label class="form-label" for="name">
                            <i class="fas fa-tag me-2"></i>اسم المنتج
                        </label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="أدخل اسم المنتج"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label" for="category_id">
                            <i class="fas fa-tag me-2"></i>اختر القسم
                        </label>
                        <select id="category_id" name="category_id"
                            class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">-- اختر القسم --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group full-width ">
                        <label class="form-label" for="price">
                            <i class="fas fa-tag me-2"></i>سعر المنتج
                        </label>
                        <input type="number" id="price" name="price"
                            class="form-control @error('price') is-invalid @enderror" placeholder="أدخل اسم المنتج"
                            value="{{ old('price') }}" required>
                        @error('price')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="form-group ">
                        <label class="form-label" for="sale_price">
                            <i class="fas fa-tag me-2"></i>سعر التخفيض
                        </label>
                        <input type="number" id="sale_price" name="sale_price"
                            class="form-control @error('sale_price') is-invalid @enderror" placeholder="أدخل اسم المنتج"
                            value="{{ old('sale_price') }}" required>
                        @error('sale_price')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label" for="stock">
                            <i class="fas fa-tag me-2"></i>الكمية / المخزون
                        </label>
                        <input type="number" id="stock" name="stock"
                            class="form-control @error('stock') is-invalid @enderror" placeholder="أدخل اسم المنتج"
                            value="{{ old('stock') }}" required>
                        @error('stock')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div> --}}





                    <div class="form-group  ">
                        <label class="form-label" for="image">
                            <i class="fas fa-image me-2"></i>صورة المنتج
                        </label>
                        <input type="file" id="image" name="image"
                            class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}">
                        @error('image')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror

                        <div class="mt-2">
                            <img id="imagePreview" src="" alt="معاينة الصورة"
                                style="width: 120px; height: 120px; object-fit: cover; display: none; border:1px solid #ccc; padding:4px; border-radius:6px;">
                        </div>
                    </div>

                    <div class="form-group  mt-3">
                        <label class="form-label" for="gallery">
                            <i class="fas fa-images me-2"></i>معرض الصور (يمكنك اختيار أكثر من صورة)
                        </label>
                        <input type="file" id="gallery" name="gallery[]"
                            class="form-control @error('gallery') is-invalid @enderror" multiple accept="image/*">

                        @error('gallery')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror

                        <div class="mt-2 d-flex flex-wrap gap-2" id="galleryPreview"></div>
                    </div>

                    {{-- الوصف --}}
                    <div class="form-group full-width">
                        <label for="description">
                            <i class="fas fa-newspaper me-2"></i>وصف المنتج
                        </label>
                        <input type="text" id="description" name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="أدخل وصف المنتج"
                            value="{{ old('description', $product->description ?? '') }}">
                        @error('description')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button id="cancelBtn" class="btn btn-secondary">إلغاء</button>
            <button id="saveBtn" class="btn btn-primary">حفظ</button>
        </div>
    </div>
</div>
