@extends('front.layouts.app')
@section('main')
<section id="carouselExample" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image: url('front-asset/images/banner2.jpg'); background-size: cover; height: 600px;">
        </div>

        <div class="carousel-item" style="background-image: url('front-asset/images/banner1.jpg'); background-size: cover; height: 600px;">
        </div>

        <!-- Thêm nhiều slide khác nếu cần -->
    </div>

    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</section>




<section class="section-1 py-5"> 
    <div class="container">
        <div class="row">
            <div class="package-title text-center mb-4">HƯỚNG DẪN ĐẶT HÀNG</div>
            
            <div class="col-md-3 text-center">
                <div class="image-text-container">
                    <img src="front-asset/images/logo5.png" style="width: 50%;" alt="">
                    <p>CHỌN GÓI ĂN</p>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="image-text-container">
                    <img src="front-asset/images/logo6.png" style="width: 50%;" alt="">
                    <p>CHỌN LỊCH ĂN</p>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="image-text-container">
                    <img src="front-asset/images/logo7.png" style="width: 50%;" alt="">
                    <p>ĐẶT HÀNG</p>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="image-text-container">
                    <img src="front-asset/images/logo8.png" style="width: 50%;" alt="">
                    <p>GIAO HÀNG</p>
                </div>
            </div>
        </div>            
    </div>
</section>

<section class="section-3  py-5">
    <div class="container">
        <h2>Sản Phẩm Ăn Giảm Cân</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @foreach($categories as $category)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body text-center">
                                    <!-- Hiển thị tên category với giới hạn chiều rộng để buộc tên xuống dòng -->
                                    <a class="category-name" href="{{  route('categories.view', ['category' => $category->id]) }}">{{ $category->name }}</a>
                        
                                    <!-- Hiển thị ảnh -->
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid mb-3">
                        
                                    <!-- Hiển thị mô tả -->
                                    <p class="mb-3 description">{{ $category->description }}</p>
                        
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
                                            {{-- <a href="#" class="btn btn-primary btn-lg" style="font-family: 'Inter-Regular'">Đặt hàng</a> --}}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-1 py-5 "> 
    <div class="container">
            <div class="row">
                <div class="package-title text-center mb-4">TIÊU CHÍ CHẤT LƯỢNG</div>

                <div class="col-md-3 text-center">
                    <div class="image-text-container">
                        <img src="front-asset/images/logo1.png" style="width: 50%" alt="">
                        <p>GIAO HÀNG TẬN NƠI</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="image-text-container">
                        <img src="front-asset/images/logo2.jpg" style="width: 50%" alt="">
                    <p>THƯC PHẨM TƯƠI SẠCH</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="image-text-container">
                        <img src="front-asset/images/logo3.png" style="width: 50%" alt="">
                    <p>KHÔNG BỘT NGỌT, ÍT GIA VỊ</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="image-text-container">
                        <img src="front-asset/images/logo4.png" style="width: 50%" alt="">
                    <p>CUNG CẤP ĐẦY ĐỦ DINH DƯỠNG</p>
                    </div>
                </div>
                
                

            </div>            
    </div>
</section>
@endsection