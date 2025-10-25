{{-- resources/views/admin/orders/_rows.blade.php --}}
@forelse ($orders as $order)
    <tr>
        {{-- رقم الطلب --}}
        <td>{{ $order->id }}</td>

        {{-- اسم العميل (لو عندك علاقة User) --}}
        <td>{{ $order->user->name ?? 'زائر' }}</td>

        {{-- إجمالي السعر --}}
        <td>{{ $order->total_price }}</td>

        {{-- حالة الطلب --}}
        <td>
            <span
                class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'completed' ? 'success' : 'secondary') }}">
                {{ $order->status }}
            </span>
        </td>

        {{-- تاريخ الإنشاء --}}
        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>

        {{-- الإجراءات --}}
        <td class="actions">
            <a href="{{ route('orders.show', $order->id) }}" class="btn-action btn-view" title="عرض التفاصيل">
                <i class="fas fa-eye"></i>
            </a>

            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline-block delete-form">
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
        <td colspan="6" class="text-center text-muted">لا توجد طلبات بعد.</td>
    </tr>
@endforelse
