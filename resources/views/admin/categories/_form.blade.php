<!-- Responsive Modal -->
<div id="modalOverlay" class="modal-overlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title">إضافة قسم جديد</h3>
            <button id="closeModalBtn" class="close-btn">&times;</button>
        </div>

        <div class="modal-body">
            {{-- ملاحظة: سيُستبدل الـaction و _method ديناميكياً عند التعديل --}}
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                id="categoryForm">
                @csrf
                <input type="hidden" id="methodSpoof" name="_method" value=""> {{-- 'PUT' عند التعديل --}}
                <input type="hidden" id="formAction" value="{{ route('categories.store') }}"> {{-- للتبديل JS --}}

                <div class="form-grid">



                    {{-- التصنيف الأب --}}
                    <div class="form-group">
                        <label for="name">اسم القسم</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="parent_id">القسم الأب (اختياري)</label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">قسم رئيسي</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group full-width ">
                        <label class="form-label" for="image">
                            <i class="fas fa-image me-2"></i>صورة القسم
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


                    {{-- الوصف --}}
                    <div class="form-group full-width">
                        <label for="description">
                            <i class="fas fa-newspaper me-2"></i>وصف القسم
                        </label>
                        <input name="description"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', isset($category) ? $category->description : '') }}
                        </input>
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
