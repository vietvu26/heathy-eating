<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Shop :: Administrative Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css')}}">
    <style>
        /* Đưa nút Đăng nhập ra giữa */
        .row {
            display: flex;
            justify-content: center;
            flex-direction: column; /* Đặt chiều dọc để sắp xếp các phần tử theo chiều dọc */
        }
        /* Đổi màu viền card thành màu xanh lá cây */
        .card {
            border-color: green;
        }
        /* Căn giữa liên kết Quên mật khẩu */
        .forgot-password {
            text-align: center;
        }
        .or-text {
            margin: 15px 0; /* Khoảng cách trên và dưới chữ "OR" */
            font-weight: bold; /* Làm đậm chữ "OR" */
            color: #333; /* Màu chữ "OR" */
        }
        .btn {
            width: 100%; /* Đặt chiều rộng nút thành 100% */
            max-width: 200px; /* Chiều rộng tối đa để nút không quá lớn */
            margin: 0 auto; /* Đưa nút ra giữa */
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        @if(session('warning'))
        <div id="warning-message" class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    @if(session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div id="error-message" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
              

        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <a href="#" class="h3">Quản lý đăng nhập</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Đăng nhập để bắt đầu mua hàng</p>
                <form action="{{ route('user.authenticate')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <p class="invalid-feedback" >{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" value="{{ old('password') }}" id="password" class="form-control @error('email') is-invalid @enderror" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success" >Đăng nhập</button>
                            <p class="or-text">OR</p>
                            <a href="{{route('customer.register')}}" class="btn btn-success">Đăng ký</a>
                        </div>
                    </div>
                    
                </form>
                <p class="mb-1 mt-3 forgot-password">
                    <a href="forgot-password.html" style="color: green">I forgot my password</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
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
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="js/demo.js"></script> --}}
</body>
</html>
