{{-- resources/views/admin/products/_rows.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp

@forelse ($products as $product)
    <tr>
        {{-- # --}}
        <td>{{ $loop->iteration }}</td>
  <td>
    <div id="carousel-{{ $product->id }}" class="carousel slide" data-bs-ride="carousel" style="width:120px;">
        <div class="carousel-inner">
            @if($product->image)
                <div class="carousel-item active">
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="d-block w-100"
                         style="height:100px; object-fit:cover; border-radius:6px;">
                </div>
            @endif
            @foreach ($product->images as $img)
                <div class="carousel-item">
                    <img src="{{ asset('storage/' . $img->image) }}"
                         alt="{{ $product->name }}"
                         class="d-block w-100"
                         style="height:100px; object-fit:cover; border-radius:6px;">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</td>

        {{-- الاسم --}}
        <td class="name">{{ $product->name }}</td>
        <td class="name">{{ $product->category->name }}</td>


        {{-- الوصف (مختصر) --}}
        <td class="description">
            {{ Str::limit(strip_tags($product->description), 50) }}
        </td>

        <td class="name">{{ $product->price }}</td>
        {{-- <td class="name">{{ $product->sale_price }}</td> --}}
        {{-- <td class="name">{{ $product->stock }}</td> --}}

        {{-- السلاج --}}
        {{-- <td class="slug">{{ $product->slug }}</td> --}}
        {{-- الإجراءات --}}
        <td class="actions">
            <a href="#" class="edit-btn btn-action btn-edit" title="تعديل" data-id="{{ $product->id }}"
                data-category="{{ $product->category_id }}" data-name="{{ $product->name }}"
                data-slug="{{ $product->slug }}" data-description="{{ e($product->description) }}"
                data-image="{{ $product->image }}" data-price="{{ $product->price }}"
                data-sale-price="{{ $product->sale_price }}" data-stock="{{ $product->stock }}"
                data-update-url="{{ route('products.update', $product->id) }}">
                <i class="fas fa-edit"></i>
            </a>


            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
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
