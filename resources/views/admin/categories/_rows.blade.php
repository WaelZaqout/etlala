{{-- resources/views/admin/categories/_rows.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp

@forelse ($categories as $category)
    <tr>
        {{-- # --}}
        <td>{{ $loop->iteration }}</td>
        <td>
            <div class="category-img-wrapper" style="width:120px;">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                    class="img-fluid rounded shadow-sm"
                    style="height:100px; width:100%; object-fit:cover; border:2px solid #eee;">
                <div class="overlay text-center">
                    <small class="text-white">{{ $category->name }}</small>
                </div>
            </div>
        </td>

        {{-- الاسم --}}
        <td class="name">{{ $category->name }}</td>

        {{-- الأب --}}
        <td class="parent">
            {{ optional($category->parent)->name ?? 'قسم رئيسي' }}
        </td>


        {{-- السلاج --}}
        <td class="slug">{{ $category->slug }}</td>

        {{-- الوصف (مختصر) --}}
        <td class="description">
            {{ Str::limit(strip_tags($category->description), 50) }}
        </td>


        {{-- الإجراءات --}}
        <td class="actions">
            <a href="#" class="edit-btn btn-action btn-edit" title="تعديل" data-id="{{ $category->id }}"
                data-name="{{ $category->name }}" data-slug="{{ $category->slug }}"
                data-description="{{ e($category->description) }}" data-image="{{ $category->image }}"
                data-update-url="{{ route('categories.update', $category->id) }}">

                <i class="fas fa-edit"></i>
            </a>

            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                class="d-inline-block delete-form">
                @csrf
                @method('delete')
                <button type="submit" class="btn-action btn-delete" title="حذف">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center text-muted">لا توجد نتائج مطابقة.</td>
    </tr>
@endforelse
