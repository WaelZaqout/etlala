    @extends('front.master')
    @section('content')
        <style>
            .breadcrumb {
                padding: 15px 20px;
                background: var(--white);
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .breadcrumb a {
                color: var(--gray);
                text-decoration: none;
                font-size: 0.9rem;
            }

            .breadcrumb span {
                color: var(--dark);
                font-weight: 600;
            }

            .main-container {
                max-width: 1200px;
                margin: 20px auto;
                padding: 20px;
                display: flex;
                gap: 30px;
            }

            @media (max-width: 768px) {
                .main-container {
                    flex-direction: column;
                }
            }

            .cart-sidebar {
                width: 300px;
                background: var(--white);
                border-radius: 12px;
                padding: 20px;
                box-shadow: var(--shadow);
            }

            .sidebar-header {
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 20px;
                background-color: var(--white);
                color: var(--dark);
                text-align: center;
            }

            .sidebar-item {
                padding: 15px 10px;
                border-bottom: 1px solid var(--light-gray);
                display: flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                transition: background 0.2s ease;
            }

            .sidebar-item:hover {
                background: rgba(99, 102, 241, 0.05);
            }

            .sidebar-item i {
                font-size: 1.2rem;
                color: var(--primary);
            }

            .total-section {
                margin-top: 20px;
                padding: 20px;
                background: #f9fafb;
                border-radius: 12px;
            }

            .total-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }

            .total-label {
                font-weight: 600;
                color: var(--gray);
            }

            .total-value {
                font-weight: 700;
                color: var(--dark);
            }

            .grand-total {
                font-size: 1.2rem;
                font-weight: 800;
                color: var(--primary);
                margin: 15px 0;
                padding-top: 15px;
                border-top: 2px solid var(--light-gray);
            }

            .cart-actions {
                display: flex;
                flex-direction: column;
                /* يخلي الأزرار تحت بعض */
                gap: 15px;
                /* مسافة بين الأزرار */
                margin-top: 20px;
            }

            .checkout-btn,
            .back-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                /* مسافة بين الأيقونة والنص */
                text-decoration: none;
                width: 100%;
                padding: 15px;
                border-radius: 12px;
                font-size: 1.1rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: var(--shadow);
            }

            .checkout-btn {
                background: #a87054;
                color: var(--white);
                border: none;
            }

            .checkout-btn:hover {
                background: #8d5d44;
                transform: translateY(-2px);
            }

            .back-btn {
                background: #aaaaac;
                color: #333;
            }

            .back-btn:hover {
                background: #e5e7eb;
                transform: translateY(-2px);
            }


            .payment-methods {
                display: flex;
                justify-content: center;
                gap: 10px;
                margin: 20px 0;
                flex-wrap: wrap;
            }

            .payment-logo {
                width: 40px;
                height: 25px;
                background: #e2e8f0;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8rem;
                font-weight: bold;
                color: var(--dark);
            }

            .guarantee {
                text-align: center;
                margin-top: 15px;
                padding: 15px;
                background: #f9fafb;
                border-radius: 12px;
                font-size: 0.9rem;
            }

            .guarantee i {
                color: var(--success);
                margin-right: 5px;
            }

            .cart-items {
                flex: 1;
                background: var(--white);
                border-radius: 12px;
                padding: 20px;
                box-shadow: var(--shadow);
            }

            .cart-title {
                font-size: 1.8rem;
                font-weight: 700;
                margin-bottom: 20px;
                color: var(--dark);
                text-align: center;
            }

            .cart-table {
                width: 100%;
                border-collapse: collapse;
            }

            .cart-table th {
                text-align: right;
                padding: 15px;
                border-bottom: 2px solid var(--light-gray);
                font-weight: 600;
                color: var(--dark);
            }

            .cart-table td {
                padding: 15px;
                border-bottom: 1px solid var(--light-gray);
                vertical-align: top;
            }

            .product-info {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .product-image {
                width: 80px;
                height: 80px;
                border-radius: 8px;
                object-fit: cover;
                box-shadow: var(--shadow);
            }

            .product-details {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .product-name {
                font-weight: 600;
                font-size: 1.1rem;
                color: var(--dark);
            }

            .product-specs {
                font-size: 0.9rem;
                color: var(--gray);
                margin-bottom: 5px;
            }

            .product-price {
                font-weight: 700;
                color: #a87054;
                font-size: 1.1rem;
            }

            .quantity-control {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .quantity-btn {
                width: 32px;
                height: 32px;
                border: 2px solid var(--light-gray);
                background: var(--white);
                border-radius: 8px;
                cursor: pointer;
                font-weight: bold;
                transition: all 0.2s ease;
            }

            .quantity-btn:hover {
                background: var(--primary);
                color: var(--white);
                border-color: var(--primary);
            }

            .quantity-input {
                width: 40px;
                height: 32px;
                text-align: center;
                border: 2px solid var(--light-gray);
                border-radius: 8px;
                font-weight: 600;
            }

            .item-actions {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .action-link {
                display: flex;
                align-items: center;
                gap: 5px;
                color: var(--gray);
                text-decoration: none;
                font-size: 0.9rem;
                transition: color 0.2s ease;
            }

            .action-link:hover {
                color: var(--primary);
            }

            .action-link i {
                font-size: 0.9rem;
            }

            .remove-item {
                color: var(--danger);
                cursor: pointer;
                font-size: 1.2rem;
                transition: transform 0.2s ease;
            }

            .remove-item:hover {
                transform: scale(1.2);
            }

            .product-tags {
                display: flex;
                gap: 5px;
                margin-top: 5px;
            }

            .tag {
                font-size: 0.8rem;
                padding: 3px 8px;
                background: #f3f4f6;
                border-radius: 12px;
                color: var(--gray);
            }

            .tag-new {
                background: #dbeafe;
                color: var(--primary);
            }

            .tag-sale {
                background: #fef3c7;
                color: var(--secondary);
            }

            .empty-cart {
                text-align: center;
                padding: 60px 20px;
                background: var(--white);
                border-radius: 20px;
                box-shadow: var(--shadow-lg);
            }

            .empty-cart i {
                font-size: 4rem;
                color: var(--light-gray);
                margin-bottom: 20px;
            }

            .empty-cart h2 {
                font-size: 2rem;
                margin-bottom: 15px;
                color: var(--gray);
            }

            .empty-cart p {
                color: var(--gray);
                margin-bottom: 30px;
                font-size: 1.1rem;
            }

            .continue-shopping {
                display: inline-block;
                padding: 12px 30px;
                background: var(--primary);
                color: var(--white);
                text-decoration: none;
                border-radius: 12px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .continue-shopping:hover {
                background: var(--primary-dark);
                transform: translateY(-2px);
            }

            /* خلفية */
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }

            /* الصندوق */
            .modal-box {
                background: #fff;
                padding: 25px;
                border-radius: 12px;
                text-align: center;
                width: 350px;
                box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
                animation: fadeIn 0.3s ease;
            }

            .modal-box h3 {
                margin-bottom: 10px;
                font-size: 1.4rem;
                color: #a87054;
            }

            .modal-box p {
                margin-bottom: 20px;
                color: #444;
            }

            .modal-actions {
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            .btn-cancel {
                background: #ccc;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
                cursor: pointer;
                font-weight: bold;
            }

            .btn-confirm {
                background: #a87054;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 8px;
                cursor: pointer;
                font-weight: bold;
            }

            .btn-confirm:hover {
                background: #8d5d44;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .remove-btn {
                background: #f8d7da;
                /* لون خلفية فاتح */
                color: #dc3545;
                /* أحمر */
                border: none;
                padding: 10px;
                border-radius: 50%;
                /* دائري */
                cursor: pointer;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            }

            .remove-btn:hover {
                background: #dc3545;
                color: #fff;
                /* أيقونة بيضاء */
                transform: scale(1.1);
                /* تكبير بسيط */
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            }

            .remove-btn i {
                pointer-events: none;
                /* عشان الضغط يكون على الزر كله */
            }

            /* 🎨 تحسين مظهر أزرار الدفع */
            .checkout-btn,
            .stripe-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                text-decoration: none;
                width: 100%;
                padding: 14px;
                border-radius: 10px;
                font-size: 1.05rem;
                font-weight: 700;
                border: none;
                cursor: pointer;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            /* الدفع عند الاستلام */
            .checkout-btn {
                background: linear-gradient(135deg, #b5835a, #a87054);
                color: #fff;
            }

            .checkout-btn:hover {
                background: linear-gradient(135deg, #a87054, #8d5d44);
                transform: translateY(-2px);
            }

            /* الدفع الإلكتروني Stripe */
            .stripe-btn {
                background: linear-gradient(135deg, #6772e5, #5469d4);
                color: #fff;
            }

            .stripe-btn:hover {
                background: linear-gradient(135deg, #5469d4, #4353c2);
                transform: translateY(-2px);
            }

            /* الأيقونات داخل الأزرار */
            .checkout-btn i,
            .stripe-btn i {
                font-size: 1.2rem;
            }
        </style>


        <div class="breadcrumb">
            <a href="#">الصفحة الرئيسية</a> <span>&lt;</span> <span>الحقيبة</span>
        </div>

        <div class="main-container">
            <div class="cart-sidebar">
                <h2 class="sidebar-header">حقيبتي ({{ $itemCount ?? 0 }})</h2>



                <!-- Totals -->
                <div class="total-section" id="cartTotals">
                    <div class="total-row">
                        <span class="total-label">عدد المنتجات</span>
                        <span class="total-value" id="itemCount">{{ $itemCount ?? 0 }}</span>
                    </div>


                    <div class="total-row">
                        <span class="total-label">الإجمالي الفرعي</span>
                        <span class="total-value" id="subtotal">{{ number_format($subtotal ?? 0, 2) }} ر.س</span>
                    </div>



                    <div class="cart-actions">
                        {{-- الدفع كاش --}}
                        <form method="POST" action="{{ route('cart.checkout.cash') }}" class="mt-2">
                            @csrf
                            <button class="checkout-btn w-100">
                                <i class="fas fa-hand-holding-usd"></i>
                                الدفع عند الاستلام
                            </button>
                        </form>

                        {{-- الدفع الإلكتروني Stripe --}}
                        <form method="POST" action="{{ route('checkout.create') }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="payment_method" value="stripe">
                            <button class="stripe-btn w-100">
                                <i class="fab fa-cc-stripe"></i>
                                الدفع الإلكتروني (Stripe)
                            </button>
                        </form>


                        <a href="{{ route('new') }}" class="back-btn">
                            <i class="fas fa-shopping-bag"></i> الرجوع للتسوق
                        </a>
                    </div>

                </div>


            </div>

            <div class="cart-items">
                <h1 class="cart-title">حقيبتي (1)</h1>

                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>المنتجات</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                        </tr>
                    </thead>
                    <tbody id="cartTable">

                        @foreach ($cartItems as $item)
                            <tr data-id="{{ $item->id }}">
                                <td>
                                    <div class="product-info">
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="product-image">
                                        <div class="product-details">
                                            <div class="product-name">{{ $item->product->name }}</div>
                                            <div class="product-specs">{{ $item->product->description }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- التحكم في الكمية --}}
                                <td>
                                    <div class="quantity-control">
                                        <button class="quantity-btn decrease">-</button>
                                        <input type="number" class="quantity-input" value="{{ $item->quantity }}"
                                            min="1">

                                        <button class="quantity-btn increase">+</button>
                                    </div>
                                </td>

                                {{-- السعر --}}
                                <td>
                                    <div class="product-price" data-unit-price="{{ $item->product->price }}">
                                        {{ $item->product->price * $item->quantity }} ر.س
                                    </div>
                                </td>


                                <td>
                                    <button class="remove-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal تأكيد الحذف -->
        <div id="confirmModal" class="modal-overlay" style="display:none;">
            <div class="modal-box">
                <h3>تأكيد الحذف</h3>
                <p>هل أنت متأكد أنك تريد إزالة هذا المنتج من السلة؟</p>
                <div class="modal-actions">
                    <button id="cancelDelete" class="btn-cancel">إلغاء</button>
                    <button id="confirmDelete" class="btn-confirm">نعم، احذف</button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const cartTable = document.getElementById("cartTable");

                // زيادة/نقصان الكمية مباشرة
                cartTable.addEventListener("click", function(e) {
                    if (e.target.classList.contains("increase") || e.target.classList.contains("decrease")) {
                        let row = e.target.closest("tr");
                        let id = row.dataset.id;
                        let input = row.querySelector(".quantity-input");
                        let currentQty = parseInt(input.value);

                        if (e.target.classList.contains("increase")) currentQty++;
                        if (e.target.classList.contains("decrease") && currentQty > 1) currentQty--;

                        // تحديث سريع في الواجهة
                        input.value = currentQty;

                        let priceElement = row.querySelector(".product-price");
                        let unitPrice = parseFloat(priceElement.dataset.unitPrice);
                        priceElement.textContent = (unitPrice * currentQty) + " ر.س";

                        // تحديث عبر Ajax
                        updateCart(id, currentQty, row);
                    }
                });

                // تعديل الكمية يدويًا
                cartTable.addEventListener("change", function(e) {
                    if (e.target.classList.contains("quantity-input")) {
                        let row = e.target.closest("tr");
                        let id = row.dataset.id;
                        let qty = parseInt(e.target.value) || 1;

                        let priceElement = row.querySelector(".product-price");
                        let unitPrice = parseFloat(priceElement.dataset.unitPrice);
                        priceElement.textContent = (unitPrice * qty) + " ر.س";

                        updateCart(id, qty, row);
                    }
                });

                // إزالة المنتج
                let productToDelete = null;

                cartTable.addEventListener("click", function(e) {
                    if (e.target.closest(".remove-btn")) {
                        let row = e.target.closest("tr");
                        productToDelete = {
                            id: row.dataset.id,
                            row: row
                        };
                        document.getElementById("confirmModal").style.display = "flex";
                    }
                });

                // أزرار المودال
                document.getElementById("cancelDelete").addEventListener("click", function() {
                    document.getElementById("confirmModal").style.display = "none";
                    productToDelete = null;
                });

                document.getElementById("confirmDelete").addEventListener("click", function() {
                    if (productToDelete) {
                        deleteCart(productToDelete.id, productToDelete.row);
                        document.getElementById("confirmModal").style.display = "none";
                    }
                });

                // --- دوال Ajax ---

                function updateCart(id, quantity, row) {
                    fetch(`/cart/${id}`, {
                            method: "PUT",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                quantity: quantity
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            // هنا نحدث فقط الإجماليات (بدون itemCount)
                            document.getElementById("subtotal").textContent = Number(data.subtotal).toFixed(2) +
                                " ر.س";
                            document.getElementById("total").textContent = Number(data.total).toFixed(2) + " ر.س";
                            document.getElementById("grandTotal").textContent = Number(data.total).toFixed(2) +
                                " ر.س";
                        })
                        .catch(err => console.error(err));
                }

                function deleteCart(id, row) {
                    fetch(`/cart/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            row.remove();
                            // هنا نحدث كل شيء بما فيهم itemCount
                            document.getElementById("itemCount").textContent = data.itemCount;
                            document.getElementById("subtotal").textContent = Number(data.subtotal).toFixed(2) +
                                " ر.س";
                            document.getElementById("total").textContent = Number(data.total).toFixed(2) + " ر.س";
                            document.getElementById("grandTotal").textContent = Number(data.total).toFixed(2) +
                                " ر.س";
                        })
                        .catch(err => console.error(err));
                }
            });
        </script>
    @endsection
