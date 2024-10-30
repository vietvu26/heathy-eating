@extends('front.layouts.app')
@section('main')


<section class="section-3 py-5">
    <div class="container">
        <div class="tieude">
            <a href="/">Trang chủ</a>
            <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
            <a href="" style="color: black">{{ $category->name }}</a> <!-- Hiển thị tên category -->
        </div>
        
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
        <div class="package-title text-center mb-4">Chi Tiết Package</div>

        <div class="row align-items-center"> 
            <div class="col-md-4"> <!-- Cột 4/12 cho ảnh -->
                <img src="{{ asset($category->image) }}" alt="" class="img-fluid"> <!-- Thêm class img-fluid để ảnh co giãn phù hợp -->
            </div>
            <div class="col-md-8 align-self-start" style="padding-left: 50px;"> <!-- Cột 8/12 cho thông tin -->
                <div style="color: #0b850b">{{ $category->name }}</div> <!-- Hiển thị tên -->
                <p class="mb-0">
                    <span class="fw-bolder">Giá:</span>
                    <span class="ps-1 fw-bolder" style="color: #fe7314">{{ number_format($category->price, 0, ',', '.') }} VND</span>
                </p>
                <p style="white-space: pre-line;">{{ $category->description }}</p> <!-- Hiển thị mô tả -->
                @if (Auth::check())
                <div>
                    <!-- Phần số lượng ở trên -->
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <p style="margin: 0; font-weight: bold;">Số lượng:</p>
                        <input type="number" id="quantityInput" name="quantity" value="1" min="1" style="width: 100px; margin-left: 10px; text-align: center;">
                    </div>
                
                    <!-- Hai nút nằm cạnh nhau -->
                    <div style="display: flex; gap: 10px;">
                        <!-- Nút Mua ngay -->
                        <form id="buyNowForm" action="{{ route('bill.view', $category->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" id="buyNowQuantity" value="1">
                            <button type="submit" class="btn btn-primary" style="font-family: 'Inter-Regular';">Mua ngay</button>
                        </form>
                
                        <!-- Nút Thêm vào giỏ hàng -->
                        <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{ $category->name }}">
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <input type="hidden" name="price" value="{{ $category->price }}">
                            <input type="hidden" name="quantity" id="cartQuantity" value="1">
                            <button type="submit" class="btn btn-primary" style="font-family: 'Inter-Regular';">Thêm vào giỏ hàng</button>
                        </form>
                    </div>
                </div>
                @else
                    <a href="{{ route('customer.login') }}" class="btn btn-primary" style="font-family: 'Inter-Regular';">Đăng nhập để mua</a>
                @endif

                </div>
                
            </div>
            
            
        </div>
        <div style="margin-top: 30px; margin-bottom: 30px; border-top: 1px solid #ccc;"></div> <!-- Đường gạch tùy chỉnh -->
        <div class="package-title text-center mb-4">Package khác</div>
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($categories->chunk(3) as $chunkIndex => $chunk)
                <div class="carousel-item @if($chunkIndex === 0) active @endif">
                    <div class="row">
                        @foreach($chunk as $category)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body text-center">
                                    <!-- Hiển thị tên category với giới hạn chiều rộng để buộc tên xuống dòng -->
                                    <a class="category-name" href="{{ route('categories.view', ['category' => $category->id]) }}">{{ $category->name }}</a>

                                    <!-- Hiển thị ảnh -->
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid mb-3">

                                    <!-- Hiển thị mô tả -->
                                    <p class="mb-3 description">
                                        {{ $category->description }}
                                       
                                    </p>
                                    
                                    <!-- Hiển thị giá -->
                                    <p class="mb-0">
                                        <span class="fw-bolder">Giá:</span>
                                        <span class="ps-1 fw-bolder" style="color: #fe7314">{{ number_format($category->price, 0, ',', '.') }} VND</span>
                                    </p>

                                    <!-- Nút Đặt hàng -->
                                    <div class="d-grid mt-3">
                                        <form action="{{ route('bill.view', $category->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary" style="font-family: 'Inter-Regular';">Đặt hàng</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <script>
            // JavaScript để cập nhật giá trị quantity khi số lượng thay đổi
            document.getElementById('quantityInput').addEventListener('input', function() {
                var quantity = this.value;
        
                // Cập nhật giá trị quantity trong các form
                document.getElementById('buyNowQuantity').value = quantity;
                document.getElementById('cartQuantity').value = quantity;
            });
        </script>
    </div>
    </div>
</section>
@endsection
