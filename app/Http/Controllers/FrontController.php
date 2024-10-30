<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $categories = Category::take(9)->get();
        return view('front.home', ['categories' => $categories]);
    }
    public function ketqua(){
        return view('front.ketqua');
    }
    public function bmi(){
        return view('front.bmi');
    }
    public function showComboPackages()
{
    // Lấy các sản phẩm có type = combo từ bảng categories
    $comboPackages = Category::where('type', 'combo')->get();

    // Trả về view và truyền danh sách combo packages vào view
    return view('front.product', compact('comboPackages'));
}
public function showCookiesPackages()
{
    // Lấy các sản phẩm có type = combo từ bảng categories
    $cookiesPackages = Category::where('type', 'cookies')->get();

    // Trả về view và truyền danh sách combo packages vào view
    return view('front.product1', compact('cookiesPackages'));
}

public function showCerealPackages()
{
    // Lấy các sản phẩm có type = combo từ bảng categories
    $cerealPackages = Category::where('type', 'cereal')->get();

    // Trả về view và truyền danh sách combo packages vào view
    return view('front.product2', compact('cerealPackages'));
}





}
