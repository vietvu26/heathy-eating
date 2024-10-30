<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Shop :: Đăng Ký</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css')}}">
    <style>
        /* Đưa form ra giữa */
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
        @include('admin.message')
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <a href="#" class="h3">Đăng Ký Tài Khoản</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Vui lòng điền thông tin của bạn</p>
                <form action="{{ route('customer.authenticate') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Tên" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('name')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Số điện thoại" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                        @error('phone')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success">Đăng Ký</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1 mt-3 forgot-password">
                    <a href="{{route('customer.login')}}" style="color: green">Đã có tài khoản? Đăng nhập</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
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
