<!DOCTYPE html>
<html class="no-js" lang="en_AU">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CareerVibe | Find Best Jobs</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css')}}">
		<link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/min/dropzone.css')}}">
		<link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote.min.css')}}">
		<link rel="stylesheet" href="{{ asset('admin/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('front-asset/css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('front-asset/css/custom.css') }}">
    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
{{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

</head>

<body data-instant-intensity="mousedown">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('front-asset/images/logo.png') }}" alt="Healthy Eating Logo" style="height: 40px;"> <!-- Điều chỉnh chiều cao logo tùy theo nhu cầu -->
                </a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('front.ketqua')}}">Kết quả</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Sản phẩm ăn giảm cân
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{route('front.combo')}}">GÓI ĂN GIẢM CÂN</a></li>
                                <li><a class="dropdown-item" href="{{route('front.cookies')}}">CÁC LOẠI BÁNH ĂN GIẢM CÂN</a></li>
                                <li><a class="dropdown-item" href="{{route('front.cereal')}}">NGŨ CỐC</a></li>
                            </ul>
                        </li>
                                    
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('front.bmi')}}">Công cụ tính BMI</a>
                        </li>							
                    </ul>
                
                    @if (!Auth::check())
                        <a class="btn btn-outline-primary me-2" href="{{ route('customer.login') }}" type="submit">Login</a>
                    @endif

                    @if (Auth::check())
                    <div class="nav-item dropdown ms-auto d-flex align-items-center">
                        <!-- Icon giỏ hàng bên trái -->
                        
                        <a href="{{ route('cart.index') }}" >
                            <i class="fas fa-shopping-cart" style="font-size: 30px; margin-right: 30px;color:#0b850b"></i> <!-- Tăng kích thước icon với font-size và thêm margin-right -->
                        </a>                    
                        <!-- Ảnh avatar bên phải -->
                        <div class="nav-item dropdown">

                            <a class="nav-link p-0" data-toggle="dropdown">
                                <img src="{{ asset('front-asset/images/avatar7.png')}}" style="width: 40px; height: 40px;" class="img-circle elevation-2" alt="">
                            </a>
                        
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('account.view') }}" class="dropdown-item">
                                    <i class="fas fa-user-cog mr-2"></i> Account
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('account.password')}}" class="dropdown-item">
                                    <i class="fas fa-lock mr-2"></i> Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    @endif
                </div>
                
            </div>
        </nav>
    </header>
    
    <main class="min-vh-100">
        @yield('main')
    </main>
    
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="image"  name="image">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mx-3">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <footer class="bg-dark py-3 bg-2">
    <div class="container">
        <p class="text-center text-white pt-3 fw-bold fs-6">© 2024 xyz company, all right reserved</p>
    </div>
    </footer> 
   
    <script src="{{ asset('front-asset/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front-asset/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('front-asset/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('front-asset/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('front-asset/js/custom.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{ asset('admin/plugins/dropzone/min/dropzone.min.js')}}"></script>
		<script src="{{ asset('admin/plugins/summernote/summernote.min.js')}}"></script>

		<!-- AdminLTE App -->
		<script src="{{ asset('admin/js/adminlte.min.js')}}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{ asset('admin/js/demo.js')}}"></script>
		<script type="text/javascript">

			$.ajaxSetup({
				headers:{
					'X-CSRF-Token': $('meta[name="csrf_token"]').attr('content')
				}
			});
			$(document).ready(function(){
				$(".summernote").summernote({
					height: 250
				});
			});
		</script>
    </body>


</html>