<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){

        return view('admin.dashboard');
    }
    public function logout(Request $request)
    {
        // Kiểm tra nếu người dùng đăng nhập với guard 'admin'
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout(); // Đăng xuất khỏi guard 'admin'
            return redirect()->route('admin.login'); // Chuyển hướng về trang đăng nhập admin
        }

        // Kiểm tra nếu người dùng đăng nhập với guard 'web' (người dùng thông thường)
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout(); // Đăng xuất khỏi guard 'web'
            return redirect()->route('customer.login'); // Chuyển hướng về trang đăng nhập người dùng
        }

        return redirect('/'); // Chuyển hướng về trang chủ nếu không có guard hợp lệ
    }
}
