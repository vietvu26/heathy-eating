<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);  // Tìm một category dựa trên ID
        return view('front.detail', compact('category','categories'));  // Truyền một category duy nhất sang view
    }
    public function home($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);  // Tìm một category dựa trên ID
        return view('front.home', compact('category','categories'));  // Truyền một category duy nhất sang view
    }
    
}
