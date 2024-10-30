@extends('front.layouts.app')

@section('main')
<section class="section-3 py-5">
    <div class="container">
        <div class="tieude">
            <a href="/">Trang chủ</a>
            <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
            <a href="" style="color: black">Bánh ăn giảm cân</a> <!-- Hiển thị tên category -->
        </div>
        <div class="package-title text-center mb-4">BÁNH ĂN GIẢM CÂN</div>
        <div class="row">
            @foreach($cookiesPackages as $category)
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
</section>
@endsection
