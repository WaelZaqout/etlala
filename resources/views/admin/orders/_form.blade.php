<!-- Responsive Modal -->
<div id="modalOverlay" class="modal-overlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title">إضافة قسم جديد</h3>
            <button id="closeModalBtn" class="close-btn">&times;</button>
        </div>

        <div class="modal-body">
            {{-- ملاحظة: سيُستبدل الـaction و _method ديناميكياً عند التعديل --}}
            <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                @csrf
                <input type="hidden" id="methodSpoof" name="_method" value=""> {{-- 'PUT' عند التعديل --}}
                <input type="hidden" id="formAction" value="{{ route('orders.store') }}"> {{-- للتبديل JS --}}

                <div class="form-grid">
                    {{-- الاسم --}}
                    <div class="form-group full-width">
                        <label class="form-label" for="user_id">
                            <i class="fas fa-tag me-2"></i>اسم العميل
                        </label>
                        <input type="text" id="user_id" name="user_id"
                            class="form-control @error('user_id') is-invalid @enderror" placeholder="أدخل اسم المنتج"
                            value="{{ old('user_id') }}" required>
                        @error('user_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group full-width ">
                        <label class="form-label" for="total_price">
                            <i class="fas fa-tag me-2"></i>اجمالي السعر
                        </label>
                        <input type="number" id="total_price" name="total_price"
                            class="form-control @error('total_price') is-invalid @enderror" placeholder="أدخل اسم المنتج"
                            value="{{ old('total_price') }}" required>
                        @error('total_price')
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
