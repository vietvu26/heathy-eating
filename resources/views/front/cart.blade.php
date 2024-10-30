@extends('front.layouts.app')

@section('main')
<div class="container">
    <h2 style="margin-top: 40px">Giỏ hàng của bạn</h2>

    @if(Session::has('success'))
    <div class="alert alert-success" id="success-alert">{{ Session::get('success') }}</div>
    <script>
        setTimeout(function() {
            var alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000); // 3 giây
    </script>
    @endif

    @if(count($cart) > 0)
        <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Chọn</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_products[]" value="{{ $item->id }}" class="product-checkbox">
                        </td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                        <td>
                            <input type="number" value="{{ $item->quantity }}" min="1" class="quantity-input" data-category-id="{{ $item->category_id }}" data-price="{{ $item->price }}">
                        </td>
                        <td class="item-total">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $item->category_id }}">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right">
                <h6>Tổng thanh toán: <span class="total-payment" style="color: #fe7314">{{ number_format($total, 0, ',', '.') }} VND</span></h6>
                <button type="submit" class="btn btn-success"style="font-family: 'Inter-Regular';">Thanh toán</button>
            </div>
        </form>
    @else
        <p style="margin-top: 40px">Giỏ hàng của bạn đang trống.</p>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const totalPaymentElement = document.querySelector('.total-payment');
        let total = {{ $total }}; // Tổng tiền ban đầu

        // Hàm cập nhật tổng số tiền
        function updateTotal() {
            let grandTotal = 0;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('tr');
                    const quantity = parseInt(row.querySelector('.quantity-input').value);
                    const price = parseInt(row.querySelector('.quantity-input').dataset.price);
                    const itemTotal = quantity * price;

                    // Cập nhật tổng tiền cho từng sản phẩm
                    row.querySelector('.item-total').innerText = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(itemTotal);

                    // Cộng dồn vào tổng thanh toán
                    grandTotal += itemTotal;
                }
            });

            // Nếu không chọn sản phẩm nào, giữ nguyên tổng
            grandTotal = grandTotal === 0 ? total : grandTotal;

            // Cập nhật tổng thanh toán
            totalPaymentElement.innerText = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(grandTotal);
        }

        // Hàm gửi AJAX để cập nhật số lượng sản phẩm trong giỏ hàng
        function updateCartQuantity(categoryId, quantity) {
            fetch("{{ route('cart.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    category_id: categoryId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Cập nhật giỏ hàng thành công.');
                } else {
                    console.error('Có lỗi xảy ra khi cập nhật.');
                }
            });
        }

        // Thêm sự kiện khi thay đổi số lượng
        quantityInputs.forEach(input => {
            input.addEventListener('input', function() {
                const categoryId = input.dataset.categoryId;
                const quantity = input.value;

                // Gửi yêu cầu cập nhật số lượng qua AJAX
                updateCartQuantity(categoryId, quantity);

                const row = input.closest('tr');
                const checkbox = row.querySelector('.product-checkbox');
                checkbox.checked = true; // Đánh dấu checkbox khi thay đổi số lượng
                updateTotal();
            });
        });

        // Cập nhật tổng khi thay đổi checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotal);
        });

        // Cập nhật tổng khi tải trang
        updateTotal();
    });
</script>

@endsection
