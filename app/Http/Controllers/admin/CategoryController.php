<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function manage() {
        $category = Category::all();
        return view('admin.category.manage', ['category' => $category]);
    }

    public function create() {
        $category = Category::all();
        return view('admin.category.create', ['category' => $category]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:combo,cereal,cookies',
            'description' => 'required|string',
            'calories' => 'required|integer',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|max:2048', 
            'status' => 'required|in:0,1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'calories' => $request->calories,
            'status' => $request->status,
        ]);

        return redirect()->route('categories.manage')->with('success', 'Add category successful!');
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:combo,cereal,cookies',
            'description' => 'required|string',
            'calories' => 'required|integer',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|max:2048', 
            'status' => 'required|in:0,1',
        ]);

        $category = Category::findOrFail($id);
        $imagePath = $category->image; 

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        $category->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'calories' => $request->calories,
            'status' => $request->status,
        ]);

        return redirect()->route('categories.manage')->with('success', 'Category updated successfully!');
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.manage')->with('success', 'Category deleted successfully!');
    }

    public function uploadImage(Request $request) {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename); // Đường dẫn đúng là 'images'

            return response()->json(['message' => 'Image uploaded successfully', 'file_path' => 'images/' . $filename], 200);
        }

        return response()->json(['message' => 'Failed to upload image'], 400);
    }
}
