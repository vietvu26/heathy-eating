<?php

namespace App\Http\Controllers;
use App\Models\User; // Thêm dòng này
use Illuminate\Support\Facades\Hash; // Thêm dòng này
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('front.login');
    }
    public function logout(Request $request)
    {
   
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout(); // Đăng xuất khỏi guard 'web'
            return redirect()->route('customer.login'); // Chuyển hướng về trang đăng nhập người dùng
        }

        return redirect('/'); // Chuyển hướng về trang chủ nếu không có guard hợp lệ
    }
    public function authenticate(Request $request)
{
    // Xác thực dữ liệu nhập vào
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->passes()) {
        // Đăng nhập bằng guard 'web' cho người dùng
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->route('front.home'); // Điều hướng đến trang người dùng
        } else {
            return redirect()->route('customer.login')->with('error', 'Tên đăng nhập hoặc mật khẩu sai');
        }
    } else {
        // Trả về lỗi khi xác thực thất bại
        return redirect()->route('customer.login')->withErrors($validator)->withInput($request->only('email'));
    }
}

}
