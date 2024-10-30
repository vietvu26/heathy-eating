@extends('front.layouts.app')

@section('main')
<div class="container">
    <div class="tieude" style="margin-top: 30px">
        <a href="/">Trang chủ</a>
        <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
        <a href="" style="color: black">Thiết lập tài khoản</a>
    </div>

    @if(session('warning'))
        <div class="alert alert-warning" id="warning-message">
            {{ session('warning') }}
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="error-message">
            {{ session('error') }}
        </div>
    @endif

    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Thông tin tài khoản</div>

                <div class="card-body">
                    <!-- Hiển thị form cập nhật thông tin -->
                    <form method="POST" action="{{ route('account.update') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary" style="font-family: 'Inter-Regular';">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Hàm để ẩn thông báo sau 3 giây
    function hideMessage(elementId) {
        const messageElement = document.getElementById(elementId);
        if (messageElement) {
            setTimeout(() => {
                messageElement.style.display = 'none';
            }, 3000); // 3000ms = 3s
        }
    }

    // Gọi hàm hideMessage cho các thông báo warning, success và error
    hideMessage('warning-message');
    hideMessage('success-message');
    hideMessage('error-message');
</script>

@endsection
