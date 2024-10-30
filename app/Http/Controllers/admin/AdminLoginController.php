<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function authenticate(Request $request)
{
    // Xác thực dữ liệu nhập vào
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->passes()) {
        // Đăng nhập bằng guard 'admin'
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            $admin = Auth::guard('admin')->user();

            // Nếu role = 0 (admin), chuyển hướng đến trang admin dashboard
            if ($admin->role == 0) {
                return redirect()->route('dashboard.manage');
            }
            // Nếu role = 1, chuyển hướng đến xác thực user
            elseif ($admin->role == 1) {
                Auth::guard('admin')->logout(); // Đăng xuất khỏi guard admin
                return $this->authenticateUser($request); // Gọi phương thức xác thực user
            } else {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'You are not allowed to access');
            }
        } else {
            return redirect()->route('admin.login')->with('error', 'Email hoặc mật khẩu không đúng');
        }
    } else {
        // Trả về lỗi khi xác thực thất bại
        return redirect()->route('admin.login')->withErrors($validator)->withInput($request->only('email'));
    }
}

}
