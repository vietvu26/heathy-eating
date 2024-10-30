@extends('front.layouts.app')

@section('main')
<div class="container">
    <div class="tieude" style="margin-top: 30px">
        <a href="/">Trang chủ</a>
        <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
        <a href="" style="color: black">Thanh toán hóa đơn </a>
        
    </div>
    
    <section class="content">
        <div class="container-fluid">
            <div class="card" style="margin-top: 40px">
                <div class="card-header">
                    <div style="text-align:center;font-weight: bold">Thanh toán hóa đơn</div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="80"></th>
                                <th style="margin-left: 20px">Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ asset($category->image) }}" class="img-thumbnail" width="50"></td>
                                <td><a href="#">{{ $category->name }}</a></td>
                                <td>{{ number_format($category->price, 0, ',', '.') }} VND</td>
                                <td>
                                    <div class="quantity-container">
                                        <!-- Nút giảm số lượng -->
                                        <button type="button" class="quantity-btn" onclick="updateQuantity(-1)">-</button>
                                        <input type="text" id="quantity" value="{{ $quantity }}" readonly>
                                        <!-- Nút tăng số lượng -->
                                        <button type="button" class="quantity-btn" onclick="updateQuantity(1)">+</button>
                                    </div>
                                </td>
                                <td id="total">{{ number_format($total, 0, ',', '.') }} VND</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id }}">
        <input type="hidden" name="price" value="{{ $category->price }}">
        <input type="hidden" name="quantity" id="form-quantity" value="{{ $quantity }}">
        <input type="hidden" name="total" id="form-total" value="{{ $total }}">

        <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 30px">
            <div style="font-size: 18px; margin-right: 20px;">
                Tổng thanh toán: <span id="total-display" style="color: #fe7314">{{ number_format($total, 0, ',', '.') }} VND</span>
            </div>
            <button type="submit" class="btn btn-success" style="font-family: 'Inter-Regular'">Mua hàng</button>
        </div>
    </form>
</div>

<style>
    /* CSS cho khung chứa số lượng */
    .quantity-container {
        display: flex;
        align-items: center;
    }

    /* CSS cho các nút + và - */
    .quantity-btn {
        background-color: white;
        border: 1px solid #ddd;
        padding: 5px 10px;
        font-size: 20px;
        cursor: pointer;
        outline: none;
        transition: background-color 0.2s;
    }

    /* Khi hover vào nút */
    .quantity-btn:hover {
        background-color: #e0e0e0;
    }

    /* CSS cho ô hiển thị số lượng */
    #quantity {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 5px;
        font-size: 18px;
        padding: 5px;
        outline: none;
    }

    /* CSS cho button mua hàng */
    .btn-success {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #28a745;
        border: none;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    /* Khi hover vào nút mua hàng */
    .btn-success:hover {
        background-color: #218838;
    }
</style>

<script>
    let price = {{ $category->price }};
    let quantity = {{ $quantity }};
    let total = {{ $total }};

    function updateQuantity(change) {
        quantity += change;
        if (quantity < 1) {
            quantity = 1; // Không cho phép số lượng dưới 1
        }

        // Cập nhật tổng tiền
        total = price * quantity;

        // Cập nhật hiển thị trên giao diện
        document.getElementById('quantity').value = quantity;
        document.getElementById('total').innerHTML = new Intl.NumberFormat('vi-VN').format(total) + ' VND';
        document.getElementById('total-display').innerHTML = new Intl.NumberFormat('vi-VN').format(total) + ' VND';

        // Cập nhật giá trị trong form
        document.getElementById('form-quantity').value = quantity;
        document.getElementById('form-total').value = total;
    }
</script>
@endsection
