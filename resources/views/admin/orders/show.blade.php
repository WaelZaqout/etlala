@extends('admin.master')

@section('title', 'تفاصيل الطلب')
@section('content')
    <div class="container mt-4">
        <h2>تفاصيل الطلب #{{ $order->id }}</h2>

        <div class="mb-3">
            <p><strong>اسم العميل:</strong> {{ $order->user->name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $order->user->email }}</p>
            <p><strong>طريقة الدفع:</strong> {{ $order->payment_method ?? 'غير محددة' }}</p>
            <p><strong>الحالة:</strong> {{ $order->status }}</p>
            <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        </div>

        <h4>المنتجات:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>صورة المنتج</th>
                    <th>اسم المنتج</th>
                    <th>الكمية</th>
                    <th>السعر الفردي</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->details as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                    width="60">
                            @else
                                <span>لا توجد صورة</span>
                            @endif
                        </td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }} $</td>
                        <td>{{ $item->price * $item->quantity }} $</td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">الإجمالي الكلي:</th>
                    <th>{{ $order->total_price }} $</th>
                </tr>
            </tfoot>
        </table>

        <a href="{{ route('orders.index') }}" class="btn btn-secondary">العودة للطلبات</a>
    </div>
@endsection
