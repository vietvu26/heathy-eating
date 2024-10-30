<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ]);

        Order::create(array_merge($request->only(['category_id', 'price', 'quantity', 'total']), ['user_id' => Auth::id()]));

        return redirect()->route('categories.view', ['category' => $request->input('category_id')])->with('success', 'Đơn hàng đã được đặt thành công!');
    }

    public function billView(Request $request, $id) 
    {
        // Kiểm tra xem người dùng có đăng nhập không
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('customer.login')->with('error', 'Bạn cần đăng nhập để mua hàng.');
        }

        // Kiểm tra thông tin khách hàng
        if (empty($user->name) || empty($user->email) || empty($user->phone) || empty($user->address)) {
            return redirect()->route('account.view')->with('warning', 'Vui lòng cập nhật đầy đủ thông tin tài khoản trước khi mua hàng .');
        }

        // Lấy thông tin category
        $category = Category::findOrFail($id);
        $quantity = $request->input('quantity', 1);
        $total = $category->price * $quantity;

        return view('front.bill', compact('category', 'quantity', 'total'));
    }
    public function showBill()
    {
        // Lấy dữ liệu từ session
        $products = session('bill_products', []);
        $total = session('total', 0);
    
        // Hiển thị trang hóa đơn
        return view('front.bill', compact('products', 'total'));
    }
    

}
