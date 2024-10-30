<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Import;
use App\Models\Category; // Đảm bảo đã import model Category
use Illuminate\Http\Request;
use App\Models\Supplier; // Đảm bảo đã import model Category

class ImportController extends Controller
{
    public function manage() {
        $imports = Import::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.import.manage', ['imports' => $imports, 'categories' => $categories, 'suppliers' => $suppliers]);
    }

    public function create() {
        $imports = Import::all(); 
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.import.create', ['imports' => $imports, 'categories' => $categories, 'suppliers' => $suppliers]);
    }

    public function store(Request $request) {
        $request->validate([
            'supplier_id' => 'required|integer|exists:suppliers,id', // Kiểm tra supplier
            'category_id' => 'required|integer|exists:categories,id', // Kiểm tra category
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        // Tính tổng tiền
        $total_price = $request->quantity * $request->unit_price;

        Import::create([
            'supplier_id' => $request->supplier_id,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $total_price, // Thêm tổng tiền vào bản ghi
        ]);
        $category = Category::find($request->category_id);
        if ($category) {
            $category->quantity += $request->quantity;
            $category->save();
        }

        return redirect()->route('imports.manage')->with('success', 'Add import successful!');
    }

    public function edit($id) {
        $supply = Import::findOrFail($id); // Lấy thông tin nhập từ ID
        $categories = Category::all(); // Lấy tất cả danh mục
        $suppliers = Supplier::all(); // Lấy tất cả nhà cung cấp
    
        return view('admin.import.edit', compact('supply', 'categories', 'suppliers')); // Truyền biến vào view
    }
    

    public function update(Request $request, $id) {
        $request->validate([
            'supplier_id' => 'required|integer|exists:suppliers,id', // Kiểm tra supplier
            'category_id' => 'required|integer|exists:categories,id', // Kiểm tra category
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $import = Import::findOrFail($id);
        $oldQuantity = $import->quantity;

        // Tính tổng tiền
        $total_price = $request->quantity * $request->unit_price;

        $import->update([
            'supplier_id' => $request->supplier_id,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $total_price, // Cập nhật tổng tiền
        ]);
        $category = Category::find($request->category_id);
        if ($category) {
            // Cập nhật lại số lượng, trừ đi số lượng cũ và cộng số lượng mới
            $category->quantity = $category->quantity - $oldQuantity + $request->quantity;
            $category->save();
        }

        return redirect()->route('imports.manage')->with('success', 'Import updated successfully!');
    }

    public function destroy($id) {
        $import = Import::findOrFail($id);
        $import->delete();
        return redirect()->route('imports.manage')->with('success', 'Import deleted successfully!');
    }
}
