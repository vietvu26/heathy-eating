<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Cart::with('category')->where('user_id', Auth::id())->get();
        $total = $cart->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('front.cart', compact('cart', 'total'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        $categoryId = $request->input('category_id');
        $price = $request->input('price');
        $quantity = $request->input('quantity');
        $name = $request->input('name');
        
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('category_id', $categoryId)
            ->first();

        if ($cartItem) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            Cart::create([
                'user_id' => Auth::id(),
                'category_id' => $categoryId,
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price
            ]);
        }

        return redirect()->route('categories.view', ['category' => $categoryId])
        ->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
        }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request)
    {
        $categoryId = $request->input('category_id');
        $quantity = $request->input('quantity');

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('category_id', $categoryId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove(Request $request)
    {
        $categoryId = $request->input('category_id');

        // Kiểm tra xem sản phẩm có trong giỏ hàng không
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('category_id', $categoryId)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
        } else {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }
    }

    // Thanh toán và tạo đơn hàng
    public function checkout(Request $request)
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('customer.login')->with('error', 'Bạn cần đăng nhập để mua hàng.');
        }
    
        // Kiểm tra thông tin khách hàng
        if (empty($user->name) || empty($user->email) || empty($user->phone) || empty($user->address)) {
            return redirect()->route('account.view')->with('warning', 'Vui lòng cập nhật đầy đủ thông tin tài khoản trước khi mua hàng.');
        }
    
        // Lấy danh sách các sản phẩm được chọn
        $selectedProductIds = $request->input('selected_products');
    
        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (empty($selectedProductIds)) {
            return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }
    
        // Lấy giỏ hàng của người dùng với các sản phẩm đã chọn
        $cart = Cart::with('category')
            ->where('user_id', Auth::id())
            ->whereIn('id', $selectedProductIds)
            ->get();
    
        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }
    
        foreach ($cart as $item) {
            // Kiểm tra nếu số lượng trong kho đủ để mua
            if ($item->category->quantity < $item->quantity) {
                return redirect()->route('cart.index')->with('error', 'Sản phẩm ' . $item->category->name . ' không đủ số lượng để thanh toán.');
            }
    
            // Tạo đơn hàng cho các sản phẩm đã chọn
            Order::create([
                'category_id' => $item->category_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->price * $item->quantity,
                'user_id' => Auth::id(),
            ]);
    
            // Giảm số lượng sản phẩm trong bảng Category
            $item->category->quantity -= $item->quantity;
            $item->category->save();
        }
    
        // Xóa các sản phẩm đã thanh toán khỏi giỏ hàng
        Cart::where('user_id', Auth::id())->whereIn('id', $selectedProductIds)->delete();
    
        return redirect()->route('cart.index')->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
    }
    
    



    
}
