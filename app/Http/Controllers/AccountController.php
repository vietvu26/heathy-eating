<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; // Sử dụng để lấy thông tin người dùng đã đăng nhập
use Illuminate\Support\Facades\Hash; // Thêm dòng này
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Trả dữ liệu về view
        return view('front.account', compact('user'));
    }
    public function showChangePasswordForm()
{
    $user = Auth::user();

    return view('front.changepass', compact('user'));
}
    public function update(Request $request)
    {
        // Lấy người dùng hiện tại
        $user = Auth::user();
    
        // Kiểm tra xem người dùng có tồn tại không
        if (!$user) {
            return redirect()->route('account.view')->withErrors('Bạn cần đăng nhập để cập nhật thông tin.');
        }
    
        // Cập nhật thông tin người dùng
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
    /** @var \App\Models\User $user **/

        // Lưu lại thay đổi
        $user->save();
    
        // Điều hướng về trang tài khoản với thông báo thành công
        return redirect()->route('account.view')->with('success', 'Thông tin tài khoản đã được cập nhật.');
    }
    public function updatePassword(Request $request)
    {
        // Validate input data
        $request->validate([
            'password' => 'required',
            'password_new' => 'required|min:8',
            'password_confirmation' => 'required|same:password_new',
        ]);

        // Retrieve the currently authenticated user
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để thực hiện chức năng này.'
            ], 403);
        }

        // Verify if the old password matches
        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu cũ không đúng.'
            ], 400);
        }

        // Ensure the new password is different from the old password
        if ($request->input('password') === $request->input('password_new')) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Mật khẩu mới phải khác mật khẩu cũ.'
            ], 400);
        }

        // Update the user's password with the new password
        $user->password = Hash::make($request->input('password_new'));

        // Save the user model with the new password
            /** @var \App\Models\User $user **/

        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Mật khẩu đã được cập nhật thành công.'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra trong quá trình cập nhật mật khẩu.'
            ], 500);
        }
    }


    
    
    

    
    

    

}
